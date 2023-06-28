<?php

namespace App\Exports;

use App\TrxQrcode;
use App\User;
use App\Merchant;
use App\MerchantItem;
use App\Promo;
use App\Qr;

use Illuminate\Support\Facades\DB;
use App\Exports\UserExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class TransactionExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder 
implements FromCollection, WithHeadings, ShouldAutoSize, WithCustomValueBinder
{
    public function __construct($month, $year) {
        $this->_month = $month;
        $this->_year = $year;
    }

    public function headings(): array
    {
        return [
            'Name Guide',
            'Item',
            'Category',
            'Discount',
            'Merchant Name',
            'Transaction at',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $bulan = $this->_month;
        $tahun = $this->_year;
        $data = TrxQrcode::join('qrcode', 'qrcode.id', '=', 'trx_qrcode.qrcode_id')
        ->join('users','users.id','=','qrcode.user_id')
        ->join('promos','qrcode.promo_id','=','promos.id')
        ->join('merchant_items','promos.item_id','=','merchant_items.id')
        ->join('merchants','merchants.id','=','merchant_items.merchant_id')
        ->select('users.name','merchant_items.name as item_name','promos.category','promos.value','merchants.name as merchant_name','trx_time')
        ->orderBy('trx_time','asc')
        ->whereYear('trx_time', $tahun)->whereMonth('trx_time', $bulan)
        ->get();

        //dd($tahun);
        
        return $data;
    }
}
