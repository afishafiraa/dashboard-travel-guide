<?php

namespace App\Exports;

use App\User;
use App\UserDetail;

use Illuminate\Support\Facades\DB;
use App\Exports\UserExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class UserExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder 
implements FromCollection, WithHeadings, ShouldAutoSize, WithCustomValueBinder 
{
    public function __construct($month, $year) {
        $this->_month = $month;
        $this->_year = $year;
    }

    public function headings(): array
    {
        return [
            'User Name',
            'Email',
            'Address',
            'Phone Number',
            'Occupation',
            'Register at',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $bulan = $this->_month;
        $tahun = $this->_year;
        $users = User::join('user_detail', 'users.id', '=', 'user_detail.user_id')
        ->select('users.name','users.email', 'user_detail.address', 'user_detail.phone_number','user_detail.ocupation','users.created_at')
        ->whereYear('users.created_at', $tahun)->whereMonth('users.created_at', $bulan)
        ->get();
        
        return $users;  
    }
}
