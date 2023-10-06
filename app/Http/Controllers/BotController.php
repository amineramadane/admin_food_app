<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\{ Bot, Question, Answer, Contact, Chatlog };
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    /**
     * api for send welcome message and first question to all contacts
     */
    public function send($id = null)
    {
        try{
            if( $id != env('BOT_ACCESS_KEY_ID')) return response()->json([ 'success' => false, 'message' => 'page not found'],404);
            if(setting('whatsapp.status') != 2) return response()->json([ 'success' => false, 'message' => 'Whatsapp deconnected']);
            if(!empty(env('URL_WA_SERVER'))) $url = env('URL_WA_SERVER').'/chat/send-bulk?id='.env('key_WA_SERVER');
            else return response()->json([ 'success' => false, 'message' => 'url bot API not found']);

            $bot = Bot::where('status', 2)->first();
            if(!$bot) {
                Log::channel('logbot')->info(['api'=> 'bot/send' ,'success' => false, 'message' => 'Bot not found']);
                return response()->json([ 'success' => false, 'message' => 'Bot not found']);
            }

            Log::channel('logbot')->info(['api'=> 'bot/send' ,'success' => true, 'message' => 'Start Api']);

            $contacts = Contact::where('status', 1)->where('number_times_sent','<', 3)->get();

            if(empty($contacts->toArray())){
                Log::channel('logbot')->info(['api'=> 'bot/send' ,'success' => false, 'message' => 'No contacts found to send']);
                return response()->json([ 'success' => false, 'message' => "No contacts found to send"]);
            }
            
            $data = [];
            foreach( $contacts as $contact ){
                $question = $questionLang = $message = null;
                $welcome_msg = optional($bot->botmessage()->where(['language_id' => $contact->language_id])->first())->welcome_message;
                $question = $bot->question()->where('status', 2)->orderBy('position')->first();
                if($question) $questionLang = $question->questionlanguage()->where('language_id',$contact->language_id)->first('message');
                if($questionLang) $message = $questionLang->message;
                if($welcome_msg && $message) $data[$contact->id] = [ "id" => $contact->id, "receiver" => $contact->phone, "welcomessage" => $welcome_msg ,"message" => $message ];
            }
            if($data){
                $response = Http::post($url,$data);
                $res = json_decode(optional($response)->getBody());
                $chatlogs = $answers = [];
                if(isset($res->success) && $res->success == true){
                    if(isset($res->data->errors)){
                        $error_ids = [];
                        foreach($res->data->errors as $contact_id){
                            $chatlogs[] = [
                                'phone' => $data[$contact_id]['receiver'],
                                'message' => $data[$contact_id]['welcomessage'],
                                'type' => 1, // 1 => send , 2 => receive
                                'status' => 1 // 1 => error , 2 => success
                            ];
                            $chatlogs[] = [
                                'phone' => $data[$contact_id]['receiver'],
                                'message' => $data[$contact_id]['message'],
                                'type' => 1, // 1 => send , 2 => receive
                                'status' => 1 // 1 => error , 2 => success
                            ];
                            unset($data[$contact_id]);
                        }
                    }
                    foreach ($data as $value){
                        $chatlogs[] = [
                            'phone' => $value['receiver'],
                            'message' => $value['welcomessage'],
                            'type' => 1, // 1 => send , 2 => receive
                            'status' => 2 // 1 => error , 2 => success
                        ];
                        $chatlogs[] = [
                            'phone' => $value['receiver'],
                            'message' => $value['message'],
                            'type' => 1, // 1 => send , 2 => receive
                            'status' => 2 // 1 => error , 2 => success
                        ];
                        $answers[] = [
                            'contact_id' => $value['id'],
                            'question_id' => $question->id,
                            'phone' => $value['receiver'],
                            'status' => 1, // 1 => sent, 2 => received, 3 => Expired
                            'number_of_reminders' => 0
                        ];
                    }
                    $return_data = [ 'success' => true, 'message' => "All messages has been successfully sent.", "message_backend" => $res];
                }else{
                    $return_data = [ 'success' => false, 'message' => "error send message", "message_backend" => $res];
                    foreach($data as $value){
                        $chatlogs[] = [
                            'phone' => $value['receiver'],
                            'message' => $value['welcomessage'],
                            'type' => 1, // 1 => send , 2 => receive
                            'status' => 1 // 1 => error , 2 => success
                        ];
                        $chatlogs[] = [
                            'phone' => $value['receiver'],
                            'message' => $value['message'],
                            'type' => 1, // 1 => send , 2 => receive
                            'status' => 1 // 1 => error , 2 => success
                        ];
                    }
                }
                if($answers) {
                    Answer::whereIn('phone', collect($answers)->pluck('phone')->toArray())->whereIn('status', [0,1])->update(['status' => 3]);
                    Answer::upsert($answers,['status','number_of_reminders','phone','contact_id','question_id']);
                    Contact::whereIn('id' ,array_keys($data))->update([
                        'status' => 2,
                        'number_times_sent' => 1,
                        'send_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }
                if(isset($res->data->errors) && !empty($res->data->errors)) {
                    Contact::whereIn('id' ,$res->data->errors)->increment('number_times_sent');
                }
                if($chatlogs) Chatlog::upsert($chatlogs,['phone','message','type','status']);
                Log::channel('logbot')->info(['api'=> 'bot/send' , $return_data]);
                return response()->json($return_data);
            }
            Log::channel('logbot')->info(['api'=> 'bot/send' ,'success' => false, 'message' => 'data not found']);
            return response()->json([ 'success' => false, 'message' => "data not found"]);
        } catch (\Exception $e) {
            Log::channel('logbot')->info(['api'=> 'bot/send' ,'success' => false, 'message' => $e->getMessage()]);
            return response()->json([ 'success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * API for receive the message; 
     * If the answer is not accepted, an error message will be returned; 
     * If the answer is accepted, the next question will be sent; 
     * If the answer is the last, a farewell message will be answered 
     * @param \Illuminate\Http\Request $request 
     * @param BOT_ACCESS_KEY_ID $id
     */
    public function receive( Request $request, $id = null )
    {
        try {
            if( $id != env('BOT_ACCESS_KEY_ID')) return response()->json([ 'success' => false, 'message' => 'page not found'], 404);
            if(!empty(env('URL_WA_SERVER'))) $url = env('URL_WA_SERVER').'/chat/send?id='.env('key_WA_SERVER');
            else return response()->json([ 'success' => false, 'message' => 'url bot API not found']);

            if ($request->isMethod('post')) {
                if(!$request->has(['phone','message'])) return response()->json([ 'success' => false, 'message' => 'bad request input']);
                $phone = trim($request->get('phone'));
                $message = trim($request->get('message'));
                $dateAnswerd = Carbon::parse(strtotime(trim($request->get('dateanswered'))))->format('Y-m-d H:i:s');
                if(strlen($message)){
                    $answer = Answer::where([ 'status' => 1, 'phone' => $phone ])->first();
                    $log_data = [
                        'phone' => $phone,
                        'message' => $message,
                        'type' => 2, // 1 => send , 2 => receive
                        'status' => 1 // 1 => error , 2 => success
                    ];
                    if(!$answer || empty($answer->contact())){
                        try{
                            $botMessage = setting('bot.message');
                            if(!empty($botMessage)){
                                Chatlog::create([
                                    'phone' => $phone,
                                    'message' => $message,
                                    'type' => 2, // 1 => send , 2 => receive
                                    'status' => 2 // 1 => error , 2 => success
                                ]);
                                Chatlog::create([
                                    'phone' => $phone,
                                    'message' => $botMessage,
                                    'type' => 1, // 1 => send , 2 => receive
                                    'status' => 2 // 1 => error , 2 => success
                                ]);
                                $response = Http::post($url,['receiver' => $phone, 'message' => $botMessage]);
                            }
                        }catch (\Exception $e) {}
                        return; // can send a simple message for client
                    }
                    $question = optional($answer->question())->first();
                    if(!$question){
                        Chatlog::create($log_data);
                        Log::channel('logbot')->info(['api'=> 'bot/receive' , 'success' => false, 'message' => 'Question\'s not found']);
                        return response()->json([ 'success' => false, 'message' => 'Question\'s not found']);
                    }
                    $nextQuestion = $question->getNextQuestion($answer->contact()->first()->language_id);
                    $chatlog = [
                        'phone' => $phone,
                        'type' => 2, // 1 => send , 2 => receive
                        'status' => 2 // 1 => error , 2 => success
                    ];
                    if($question->answer_type == 1){
                        if(Str::contains($question->condition,':')){
                            $range = Str::of($question->condition)->explode(':')->toArray();
                            $min = $range[0] + 0;
                            $max= $range[1] + 0;
                            if($min > $max){
                                $temp_var = $min;
                                $min = $max;
                                $max = $temp_var;
                            }
                            if( preg_match("/^[0-9]*$/i", $message) && (int)$message >= $min && (int)$message <= $max ){
                                $message = $message + 0;
                                $chatlog['message'] = $message;
                                Chatlog::create($chatlog);
                                $answer->status = 2;
                                $answer->answered_at = $dateAnswerd;
                                $answer->answer = $message;
                                $answer->save();
                                if ( $message <= 6 ) {
                                    $excuseMessage = $question->bot()->first()->botmessage()->where('language_id',$answer->contact()->first()->language_id)->first('excuse_message')->excuse_message;
                                    $resp = Http::post($url,['receiver' => $phone, 'message' => $excuseMessage]);
                                    $resp = json_decode(optional($resp)->getBody());
                                    if(isset($resp->success) && $resp->success == true){
                                        Chatlog::create([
                                            'phone' => $phone,
                                            'message' => $excuseMessage,
                                            'type' => 1, // 1 => send , 2 => receive
                                            'status' => 2 // 1 => error , 2 => success
                                        ]);
                                    }else{
                                        Chatlog::create([
                                            'phone' => $phone,
                                            'message' => $excuseMessage,
                                            'type' => 1, // 1 => send , 2 => receive
                                            'status' => 1 // 1 => error , 2 => success
                                        ]);
                                    }
                                }
                                if($nextQuestion){
                                    $answer_msg = [
                                        'status' => 1,  // 1 => sent, 2 => received, 3 => Expired
                                        'number_of_reminders' => 0,
                                        'contact_id' => $answer->contact_id,
                                        'phone' => $answer->phone,
                                        'question_id' => $nextQuestion->question_id,
                                    ];
                                    $sendmessage = optional($nextQuestion)->message ?? null;
                                }
                                else $sendmessage = optional($answer->getCancelMsg($answer->contact()->first()->language_id))->message;
                                $data = [ 'success' => true, 'message' => 'good response'];
                            }else{
                                $chatlog['message'] = $message;
                                $chatlog['status'] = 1;
                                Chatlog::create($chatlog);
                                $sendmessage = $question->questionlanguage()->where('language_id', $answer->contact()->first()->language_id)->first()->error_message;
                                $chatlog['message'] = $sendmessage;
                                $data = [ 'success' => false, 'message' => 'bad response (1)'];
                            }
                        }
                        elseif(Str::contains($question->condition,';')){
                            $choises = Str::of($question->condition)->explode(';')->toArray();
                            if(in_array($message, $choises, true)){
                                $chatlog['message'] = $message;
                                Chatlog::create($chatlog);
                                
                                $answer->answer = $message;
                                $answer->status = 2;
                                $answer->answered_at = Carbon::now();
                                $answer->save();
                                
                                $statusChoices = array_combine(
                                    explode(';',$question->condition),
                                    explode('|',$question->status_choices)
                                );
        
                                if ( $statusChoices[ $message ] == 10 ) {
                                    $excuseMessage = $question->bot()->first()->botmessage()->where('language_id',$answer->contact()->first()->language_id)->first('excuse_message')->excuse_message;
                                    
                                    $resp = Http::post($url,['receiver' => $phone, 'message' => $excuseMessage]);
                                    $resp = json_decode(optional($resp)->getBody());
                                    if(isset($resp->success) && $resp->success == true){
                                        Chatlog::create([
                                            'phone' => $phone,
                                            'message' => $excuseMessage,
                                            'type' => 1, // 1 => send , 2 => receive
                                            'status' => 2 // 1 => error , 2 => success
                                        ]);
                                    }else{
                                        Chatlog::create([
                                            'phone' => $phone,
                                            'message' => $excuseMessage,
                                            'type' => 1, // 1 => send , 2 => receive
                                            'status' => 1 // 1 => error , 2 => success
                                        ]);
                                    }
                                }

                                if($nextQuestion){
                                    $answer_msg = [
                                        'status' => 1, // 1 => sent, 2 => received, 3 => Expired
                                        'number_of_reminders' => 0,
                                        'contact_id' => $answer->contact_id,
                                        'phone' => $answer->phone,
                                        'question_id' => $nextQuestion->question_id,
                                    ];
                                    $sendmessage = optional($nextQuestion)->message;
                                }
                                else $sendmessage = $answer->getCancelMsg($answer->contact()->first()->language_id);
                                $data = [ 'success' => true, 'message' => 'good response'];
                            }else{
                                $chatlog['message'] = $message;
                                $chatlog['status'] = 1;
                                Chatlog::create($chatlog);
                                $sendmessage = $question->questionlanguage()->where('language_id', $answer->contact()->first()->language_id)->first()->error_message;
                                $data = [ 'success' => false, 'message' => 'bad response (2)'];
                            }
                        }else{
                            Log::channel('logbot')->info(['api'=> 'bot/receive' , 'success' => false, 'message' => 'error condition']);
                            return response()->json([ 'success' => false, 'message' => 'error condition']);
                        }
                    }elseif($question->answer_type == 2){
                        $chatlog['message'] = $message;
                        Chatlog::create($chatlog);
                        $answer->answer = $message;
                        $answer->status = 2;
                        $answer->answered_at = Carbon::now();
                        $answer->save();

                        if ( $nextQuestion ) {
                            $answer_msg = [
                                'status' => 1,  // 1 => sent, 2 => received, 3 => Expired
                                'number_of_reminders' => 0,
                                'contact_id' => $answer->contact_id,
                                'phone' => $answer->phone,
                                'question_id' => $nextQuestion->question_id,
                            ];
                            $sendmessage = $nextQuestion->message;
                        }
                        else $sendmessage = $answer->getCancelMsg($answer->contact()->first()->language_id);
                        $data = [ 'success' => true, 'message' => 'good response'];
                    }else{
                        $chatlog['message'] = $message;
                        $chatlog['status'] = 1;
                        Chatlog::create($chatlog);
                        Log::channel('logbot')->info(['api'=> 'bot/receive' , 'success' => false, 'message' => 'error type condition']);
                        return response()->json([ 'success' => false, 'message' => 'error type condition']);
                    }
                    $chatlog['type'] = 1;
                    if( isset( $sendmessage ) && !empty( $sendmessage ) ) {
                        $response = Http::post($url,['receiver' => $phone, 'message' => $sendmessage]);
                        $res = json_decode(optional($response)->getBody());
                        $chatlog['message'] = $sendmessage;
                    }
                    if(isset($res->success) && $res->success == true){
                        if(isset($answer_msg)) Answer::upsert($answer_msg,['status','phone','contact_id','question_id']);
                        $chatlog['status'] = 2;
                    }else{
                        if(isset($answer_msg)){
                            $answer_msg['status'] = 0;
                            Answer::upsert($answer_msg,['status','phone','contact_id','question_id']);
                        }
                        $chatlog['status'] = 1;
                    }
                    Chatlog::create($chatlog);
                    Log::channel('logbot')->info(['api'=> 'bot/receive' , $data]);
                    return response()->json($data);
                }else{
                    $log_data = [
                        'phone' => $phone,
                        'message' => $message,
                        'type' => 2, // 1 => send , 2 => receive
                        'status' => 1 // 1 => error , 2 => success
                    ];
                    Chatlog::create($log_data);
                    Log::channel('logbot')->info(['api'=> 'bot/receive' , 'success' => false, 'message' => 'message not found']);
                    return response()->json([ 'success' => false, 'message' => 'message not found']); // can send a simple message for client
                };
            }
            Log::channel('logbot')->info(['api'=> 'bot/receive' , 'success' => false, 'message' => 'bad request method']);
            return response()->json([ 'success' => false, 'message' => 'bad request method']);
        } catch (\Exception $e) {
            Log::channel('logbot')->info(['api'=> 'bot/receive' ,'success' => false, 'message' => $e->getMessage()]);
            return response()->json([ 'success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * API for reminder the contact; 
     * If the answer is not accepted, an error message will be returned; 
     * If the answer is accepted, the next question will be sent; 
     * If the answer is the last, a farewell message will be answered 
     * @param BOT_ACCESS_KEY_ID $id
     */
    public function reminder($id = null) 
    {
        try{
            if( $id != env('BOT_ACCESS_KEY_ID')) return response()->json([ 'success' => false, 'message' => 'page not found'], 404);
            if(setting('whatsapp.status') != 2) return response()->json([ 'success' => false, 'message' => 'Whatsapp deconnecter']);
            if(!empty(env('URL_WA_SERVER'))) $url = env('URL_WA_SERVER').'/chat/send-bulk?id='.env('key_WA_SERVER');
            else return response()->json([ 'success' => false, 'message' => 'url bot API not found']);
            $data = [];
            $bot = Bot::where('status', 2)->first();
            if(!$bot) return response()->json([ 'success' => false, 'message' => 'Bot not found']);
            $date_reminder = Carbon::now()->subMinutes($bot->reminder_time)->format('Y-m-d H:i:s');
            Log::channel('logbot')->info(['api'=> 'bot/reminder' ,'success' => true, 'message' => 'start api reminder']);
            $answers = Answer::where([
                ['status','=',1],
                ['number_of_reminders', '<', $bot->number_reminders],
                ['updated_at','<=', $date_reminder]
            ])
            ->orWhere('status', '=', 0)->get();
            // dd($answers,$date_reminder,$bot->number_reminders);
            foreach( $answers as $answer ){
                $question = $questionLang = $message = null;
                if( false == $question = $answer->question()->first() ) continue;
                if($bot->id !== $question->bot_id) continue;
                if( false == $contact = $answer->contact()->first() ) continue;
                else $questionLang = $question->questionlanguage()->where('language_id',$contact->language_id)->first('message'); 
                $message = $questionLang->message;
                if($message){
                    $data[$answer->id] = ["id" => $answer->id, "receiver" => $answer->contact()->first()->phone, "message" => $message ];
                    // $answer->updated_at = Carbon::now();
                    // $answer->save();
                }else continue;
            }
            if($data){
                $response = Http::post($url,$data);
                $res = json_decode(optional($response)->getBody());
                $chatlogs = [];
                if(isset($res->success) && $res->success == true){
                    $return_data = [ 'success' => true, 'message' => "All messages have been sent successfully.", "message_backend" => $res];
                    $error_send = false;
                    if(isset($res->data->errors)){
                        $error_send = true;
                        $return_data = [ 'success' => true, 'message' => "Some messages have been sent successfully.", "message_backend" => $res];
                    }
                    foreach ($data as $answer_id => $value){
                        if($error_send && in_array($answer_id, $res->data->errors)){
                            $chatlogs[] = [
                                'phone' => $value['receiver'],
                                'message' => $value['message'],
                                'type' => 1, // 1 => send , 2 => receive
                                'status' => 1 // 1 => error , 2 => success
                            ];
                            unset($data[$answer_id]);
                        }else{
                            $chatlogs[] = [
                                'phone' => $value['receiver'],
                                'message' => $value['message'],
                                'type' => 1, // 1 => send , 2 => receive
                                'status' => 2 // 1 => error , 2 => success
                            ];
                        }
                    }
                }else{
                    $return_data = [ 'success' => false, 'message' => "error send message", "message_backend" => $res];
                    foreach($data as $k => $value){
                        $chatlogs[] = [
                            'phone' => $value['receiver'],
                            'message' => $value['message'],
                            'type' => 1, // 1 => send , 2 => receive
                            'status' => 1 // 1 => error , 2 => success
                        ];
                        unset($data[$k]);
                    }
                }
                if(isset($res->data->errors) && !empty($res->data->errors)) {
                    Answer::whereIn('id' ,$res->data->errors)->update(['status' => 0]);
                }
                if(!empty($data)) {
                    Answer::whereIn('id', array_keys($data))
                    ->update([
                        'status' => 1,
                        'number_of_reminders' => DB::raw('number_of_reminders + 1')
                    ]);
                }
                if($chatlogs) Chatlog::upsert($chatlogs,['phone','message','type','status']);
                Log::channel('logbot')->info(['api'=> 'bot/reminder' , 'data' => $return_data]);
                return response()->json($return_data);
            }
            Log::channel('logbot')->info(['api'=> 'bot/reminder' ,'success' => true, 'message' => 'There is no reminder']);
            return response()->json([ 'success' => false, 'message' => 'There is no reminder']);
        }catch (\Exception $e) {
            Log::channel('logbot')->info(['api'=> 'bot/reminder' ,'success' => false, 'message' => $e->getMessage()]);
            return response()->json([ 'success' => false, 'message' => $e->getMessage()]);
        }
    }
}
