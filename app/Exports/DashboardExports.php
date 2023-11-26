<?php
namespace App\Exports;

use App\Models\salesTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
    use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

    class DashboardExports implements FromQuery , WithMapping, WithHeadings{
        use Exportable;
        /**
    * @var SalesTransaction $row
    */
        protected $from = '';
        protected $to = '';
        public function __construct(Request $request)
        {
            $data = $request->all();
            $this->from = date($data['from']);
            $this->to = date($data['to']);
            
        }
        
        public function query(){
            $date = date(Carbon::now());
            $from = $this->from;
            $to = $this->to;
            
            $transaction = salesTransaction::query();
            $transaction = $transaction->selectRaw('clients.clientName as Nama, COUNT(sales_transactions.client_id) as Total, sales_transactions.productPrice * sales_transactions.productCount as TotalTransaksi, unit_usahas.usahaName as UnitUsaha, unit_usahas.id as UnitUsahaId, provinsis.provinsiName as Provinsi, kotas.kota as Kota, kecamatans.kecamatanName as Kecamatan, kelurahans.kelurahanName as Kelurahan, provinsis.id as IDProvinsi, kotas.id as IDKota, kecamatans.id as IDKecamatan, kelurahans.id as IDKelurahan, sales_transactions.created_at')
            ->join('provinsis','sales_transactions.provinsi_id', '=', 'provinsis.id')
            ->join('clients','sales_transactions.client_id', '=', 'clients.id')
            ->join('kotas','sales_transactions.kota_id', '=', 'kotas.id')
            ->join('kecamatans','sales_transactions.kecamatan_id', '=', 'kecamatans.id')
            ->join('kelurahans','sales_transactions.kelurahan_id', '=', 'kelurahans.id')
            ->join('products','sales_transactions.product_id', '=', 'products.id')
            ->join('unit_usahas','sales_transactions.unit_usaha_id', '=', 'unit_usahas.id')
            ->join('transactions','sales_transactions.transaction_id', '=', 'transactions.id')
            ->whereRaw("transactions.transactionStatus != 'BELUMTERVERIFIKASI' AND transactions.transactionStatus != 'BATAL' AND sales_transactions.kelurahan_id = kelurahans.id AND sales_transactions.kecamatan_id = kecamatans.id AND sales_transactions.kota_id = kotas.id AND sales_transactions.provinsi_id = provinsis.id AND products.id = sales_transactions.product_id AND sales_transactions.unit_usaha_id = unit_usahas.id");
            if(!$from=='' && !$to==''){
                $transaction = $transaction->whereBetween('sales_transactions.created_at',[$from,$to]);
            } else if(!$from==''){
                $transaction = $transaction->whereBetween('sales_transactions.created_at',[$from,$date]);
            } else if(!$to==''){
                $to = $date;
                $transaction = $transaction->whereBetween('sales_transactions.created_at',['2020-01-01',$to]);
            } else {
                $transaction = $transaction->whereBetween('sales_transactions.created_at',['2020-01-01',$date]);
            }
            return $transaction;
        }
        public function headings(): array
        {
            return [
                'Nama',
                'Total Transaksi',
                'Unit Usaha',
                'Provinsi',
                'Kabupaten / Kota ',
                'Kecamatan',
                'Kelurahan',
                'Tanggal'
            ];
        }
        public function map($row): array
        {   
            return [
                $row->Nama,
                $row->TotalTransaksi,
                $row->UnitUsaha,
                $row->Provinsi,
                $row->Kota,
                $row->Kecamatan,
                $row->Kelurahan,
                $row->created_at,
            ];
        }
    }
?>