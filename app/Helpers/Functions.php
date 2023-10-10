<?php

/**
 * Success response method
 *
 * @param $result
 * @param $message
 * @return \Illuminate\Http\JsonResponse
 */
function sendResponse($result, $message)
{
    $response = [
        'success' => true,
        'data' => $result,
        'message' => $message,
    ];

    return response()->json($response, 200);

}

/**
 * Return error response
 *
 * @param       $error
 * @param array $errorMessages
 * @param int   $code
 * @return \Illuminate\Http\JsonResponse
 */
function sendError($error, $errorMessages = [], $code = 400)
{
    $response = [
        'success' => false,
        'message' => $error,
    ];

    !empty($errorMessages) ? $response['data'] = $errorMessages : null;


    return response()->json($response, $code);
    ;
}

/**
 * function that checks whether an array is associative or indexed,
 * and converts it to an associative array if it is not already
 * @param array associative or indexed array
 * @return array associative array
 */
function convert_to_associative_array($array) {
    try {
        // Check if the array is already associative
        if (array_keys($array) !== range(0, count($array) - 1)) {
            return $array; // Return the array as is
        }

        // Create a new associative array with the same values as the indexed array
        $assoc_array = array();
        foreach ($array as $value) {
            $assoc_array[$value] = $value;
        }
        return $assoc_array;
    } catch (\Throwable $th) {
        return $array;
    }
}

