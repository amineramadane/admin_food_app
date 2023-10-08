<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\{Arr, Str, Collection};
use Illuminate\Support\Facades\{Schema, DB};

trait SinglePageTrait
{
    protected $paginationTheme = 'bootstrap';
    public $Model;
    public $ModelRoute;
    public $ModelAttributes;
    public $ObjectFilter;
    public $Object;
    public $indexRules;
    public $createRules;
    public $editRules;
    public $showRules;

    // default value
    public $view = 'index';
    public $sortColumn = 'created_at';
    public $sortDirection = 'DESC';
    public $perPage = 20;
    public $DisplayButtons = ['add' => true, 'edit' => true, 'create' => true, 'delete' => true, 'show' => true, 'export' => true, 'import' => true];

    public $BackgroundColorStatus =
    [
        '0' => 'DarkGray',
        '1' => 'DarkOrange',
        '2' => 'OrangeRed',
        '3' => 'Gold',
        '4' => 'YellowGreen',
        '5' => 'DarkGray',
    ];

    public $imageMorph;

    public function nameModel()             { return Str::replace( '_', ' ', Str::title(Str::singular($this->ObjectFilter->getTable()))); }

    public function viewIndex()             { $this->view = 'index'; }
    
    public function viewShow($id)           { $this->Object = $this->Model::find($id); $this->view = 'show'; }
    
    public function viewCreate()            { $this->Object = new $this->Model ; $this->view = 'create'; }

    public function viewEdit($id)           { $this->Object = $this->Model::find($id); $this->view = 'edit'; }

    public function dehydrate()             { $this->dispatchBrowserEvent('livewire:load'); }

    public function resetFilter()           { $this->ObjectFilter = new $this->Model; }

    public function updatingObjectFilter()  { $this->resetPage(); }

    public function mountSync($id = null)
    {
        if($this->ModelRoute == null) $this->ModelRoute = (new $this->Model)->getTable();
        if($this->ModelAttributes == null) $this->ModelAttributes = $this->ModelAttributes ?? Schema::getColumnListing($this->ModelRoute);
        if($this->ObjectFilter == null) $this->ObjectFilter = new $this->Model;
        if($this->Object == null) $this->Object = $this->Model::find($id);
    }

    public function mountSyncUrl()
    {
        if(request()->is('*/create')) $this->viewCreate();
        elseif($this->Object != null)
        {
            if(request()->is('*/edit')) $this->viewEdit(request()->id);
            else $this->view = 'show';
        }
    }

    public function renderSyncUrl()
    {
        if($this->view == 'create') $this->emit('renderSyncUrl', route($this->ObjectFilter->getTable().'.create'));
        elseif($this->view == 'edit') $this->emit('renderSyncUrl', route($this->ObjectFilter->getTable().'.edit', $this->Object->id));
        elseif($this->view == 'show') $this->emit('renderSyncUrl', route($this->ObjectFilter->getTable().'.show', $this->Object->id));
        else $this->emit('renderSyncUrl', route($this->ObjectFilter->getTable().'.index'));
    }

    public function renderSync()
    {
        if($this->view == 'index')
        {
            $this->displayColumnsSorted = $this->ObjectFilter->displayColumns;
            uasort($this->displayColumnsSorted, function ($first, $second) {
                return (isset($first['filter']['pos']) ? $first['filter']['pos'] : 30) <=> (isset($second['filter']['pos']) ? $second['filter']['pos'] : 30);
            });
        }
    }

    public function renderSyncRules()
    {
        // if this view is index and rules is null => generate indexRules
        if($this->view == 'index' && $this->indexRules == null)
            foreach ($this->ObjectFilter->displayColumns as $key1 => $value1)
                if(isset($value1['filter']))
                    foreach ($value1['filter']['by'] ?? [$key1] as $key2 => $value2)
                        $this->indexRules['ObjectFilter.'.$value2] = '';
        if($this->view == 'index') $this->rules = $this->indexRules;
        if($this->view == 'create') $this->rules = array_merge($this->indexRules ?? [], $this->createRules ?? $this->editRules ?? []);
        if($this->view == 'edit') $this->rules = array_merge($this->indexRules ?? [], $this->editRules ?? []);
        if($this->view == 'show') $this->rules = array_merge($this->indexRules ?? [], $this->showRules ?? $this->editRules ?? []);
    }
    
    public function save()
    {
        DB::beginTransaction();
        if($this->validate()){
            try {
                $this->Object->save();
                if(!empty($this->imageMorph)) {
                    $path = $this->imageMorph->store('public/images');
                    if(optional($this->Object->image)->path) {
                        $this->Object->image()->update(['path' => $path]);
                    }else {
                        $this->Object->image()->save(Image::make(['path' => $path]));
                    }
                }
                // if(isset($this->Object->morphImage) && !empty($this->Object->morphImage)) {
                //     $this->Object->morphImage = $this->image->store('public/images');
                // }
                if($this->Object->wasRecentlyCreated) session()->flash('success', __($this->nameModel()) . __('created'));
                else session()->flash('success', __($this->nameModel()) . __('updated'));
                DB::commit();
                $this->viewIndex();
            }catch(\Exception $e) {
                DB::rollback();
                session()->flash('error',$e->getMessage());
                // session()->flash('error', __("There has been an error!"));
            }
        }
    }

    public function delete($id)
    {
        try {
            $this->Model::find($id)->delete();
            session()->flash('success', __($this->nameModel()) . __('deleted'));
        } catch (\Throwable $th) {
            session()->flash('error', __($this->nameModel()) . __('not deleted'));
        }
        $this->viewindex();
    }

    public function dataTable()
    {
        if($this->view == 'index') $Table = $this->filter()->orderBy($this->ModelRoute.'.'.$this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        if($this->view == 'index')
        {
            $TableList = $this->filter()->orderBy($this->ModelRoute.'.'.$this->sortColumn, $this->sortDirection);
            $Table = $TableList->paginate($this->perPage);

            if($Table->currentPage() > $Table->lastPage()){
                $this->gotoPage($Table->lastPage());
                $Table = $TableList->paginate($this->perPage);
            }
        }
        return $Table;
    }

    public function join($query, $attribute)
    {
        $objectOld = new $this->Model;
        foreach ($loop = explode('.', $attribute) as $value) {

            if(end($loop) != $value && class_exists($ModelNew = 'App\\'. 'Models\\' . studly_case($value))) // Not a Last line && Model Exists
            {
                $objectNew = new $ModelNew;
                $foreignKey = $objectNew->getForeignKey();
                if($objectNew->getTable() == 'ordre_fabrications') $foreignKey = 'order_fabrication_id'; // un cas exceptionel
                if(!Collection::make($query->getQuery()->joins)->pluck('table')->contains($objectNew->getTable()))
                    $query->join($objectNew->getTable(), $objectNew->getTable().'.id', '=', $objectOld->getTable().'.'.$foreignKey);
                $objectOld = $objectNew;
            }
            else $attribute = $objectOld->getTable().'.'.$value; // Last line
        }
        return [$query, $objectOld];
    }

    public function filter()
    {
        return $this->Model::select((new $this->Model)->getTable().'.*')->when(true, function($query){
            $ObjectDotList = Arr::dot($this->ObjectFilter->toArray());
            foreach ($this->ObjectFilter->displayColumns as $key => $displayColumn) {
                if(isset($displayColumn['filter'])){
                    foreach ($displayColumn['filter']['by'] ?? [$key] as $columnName) {
                        if(isset($ObjectDotList[$columnName]) && (!empty($ObjectDotList[$columnName]) || $ObjectDotList[$columnName] === 0 || $ObjectDotList[$columnName] === '0')){

                            [$query, $objectOld] = $this->join($query, $columnName);
                            $loop = explode('.', $columnName);
                            $tableWithColumnName = $objectOld->getTable().'.'.end($loop);
                            switch($displayColumn['filter']['type'] ?? 'exact') // new2
                            {
                                case 'likeRange':
                                    $query->where(function ($query1) use ($query, $displayColumn, $tableWithColumnName, $ObjectDotList, $columnName) {
                                        foreach ($displayColumn['filter']['by'] as $key => $columnName1) {
                                            [$query, $objectOld] = $this->join($query, $columnName1);
                                            $loop = explode('.', $columnName1);
                                            $tableWithColumnName = $objectOld->getTable().'.'.end($loop);
                                            $query1->orWhere($tableWithColumnName, 'like', '%'.$ObjectDotList[$columnName].'%');
                                        }
                                    });
                                    break;
                                case 'like':
                                    $query->where($tableWithColumnName, 'like', '%'.$ObjectDotList[$columnName].'%');
                                    break;
                                case 'date': case 'datetime': case 'dateRange':
                                    if(Str::endsWith(last(explode('.', $tableWithColumnName)), '_start')) $query->whereDate(str_replace('_start', '', $columnName), '>=', $ObjectDotList[$columnName]);
                                    elseif(Str::endsWith(last(explode('.', $tableWithColumnName)), '_end')) $query->whereDate(str_replace('_end', '', $columnName), '<=', $ObjectDotList[$columnName]);
                                    else $query->whereDate($tableWithColumnName, $ObjectDotList[$columnName]);
                                    break;
                                default:
                                    $query->where($tableWithColumnName,$ObjectDotList[$columnName]);
                                    break;
                            }
                            
                        }
                    }
                }
            }
        });
    }

    public function sort($column)
    {
        if($this->sortColumn == $column && $this->sortDirection == 'DESC')
            $this->sortDirection = 'ASC';

        else if($this->sortColumn == $column && $this->sortDirection == 'ASC') {
            $this->sortColumn = 'created_at';
            $this->sortDirection = 'DESC';

        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'DESC';
        }
    }
}
