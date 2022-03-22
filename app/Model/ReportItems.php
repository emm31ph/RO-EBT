<?php

namespace App\Model;

use App\Model\ReportItems;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class ReportItems extends Model
{
    use Sortable;
    
    protected $table = 'report_item';
    public $fillable = ['header1', 'header2', 'header3','itemcode','type'];

    public $sortable = ['header1', 'header2', 'header3','itemcode','type'];
 
    public function childs()
    {
        return $this->hasMany(ReportItems::class, 'parent_id', 'id');
    }

     
}
