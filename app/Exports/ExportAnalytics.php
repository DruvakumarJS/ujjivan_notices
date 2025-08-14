<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\DeviceData;
use App\Models\Devices;

class ExportAnalytics implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $from = "2025-05-01";
        $to = "2025-06-30";

        $data = [];
        $last = strtotime($to);

        $devices = Devices::whereBetween('id',[75,84])->get();

        foreach ($devices as $dev) {
            $now = strtotime($from); // reset for each device

            while ($now <= $last) {
                if (DeviceData::where('device_id', $dev->id)
                    ->where('last_updated_date', date('Y-m-d', $now))
                    ->exists()
                ) {
                    $firstdata = DeviceData::where('device_id', $dev->id)
                        ->where('last_updated_date', date('Y-m-d', $now))
                        ->first();

                    $lastdata = DeviceData::where('device_id', $dev->id)
                        ->where('last_updated_date', date('Y-m-d', $now))
                        ->orderBy('id', 'DESC')
                        ->first();

                    $details = DeviceData::where('device_id', $dev->id)
                        ->where('last_updated_date', date('Y-m-d', $now))
                        ->get();

                    $deviceName = $firstdata->deviceinfo->branch->branch_code ?? '--';

                    $running_minutes = 0;
                    $idle_minutes = 0;
                    $d1 = null;

                    foreach ($details as $key => $value) {
                        if ($key == 0) {
                            $d1 = date('Y-m-d', $now) . ' ' . $value->last_updated_time;
                        } else {
                            $d2 = date('Y-m-d', $now) . ' ' . $value->last_updated_time;
                            $diff = strtotime($d2) - strtotime($d1);
                            $minutes = $diff / 60;

                            if ($minutes <= 20) {
                                $running_minutes += $minutes;
                            } else {
                                $idle_minutes += $minutes;
                            }
                            $d1 = $d2;
                        }
                    }

                    $total_running = $running_minutes
                        ? floor($running_minutes / 60) . "Hr : " . ($running_minutes % 60) . "Min"
                        : '0 Min';

                    $total_idle = $idle_minutes
                        ? floor($idle_minutes / 60) . "Hr : " . ($idle_minutes % 60) . "Min"
                        : '0 Min';

                    $date = date('Y-m-d', $now);
                    $boot_on = $firstdata->last_updated_time;
                    $boot_off = $lastdata->last_updated_time;
                } else {
                    $date = date('Y-m-d', $now);
                    $boot_on = '--';
                    $boot_off = '--';
                    $total_running = '--';
                    $total_idle = '--';
                    $running_minutes = 0;
                    $idle_minutes = 0;
                    $deviceName = '--';
                }

                $res = [
                    'deviceName' => $deviceName,
                    'date' => $date,
                    'boot_on_time' => $boot_on,
                    'boot_off_time' => $boot_off,
                    'total_running_hours' => $total_running,
                    'total_idle_hours' => $total_idle,
                   // 'minutes_running' => $running_minutes,
                   // 'minutes_idle' => $idle_minutes
                ];

                $data[] = $res;
                $now = strtotime('+1 day', $now);
            }
        }

 return collect($data);
        //print_r(json_encode($data));die();
    }

    public function headings(): array
	{       
	   return [
	     'Device Name','Date','Device Boot On Time','Device Boot Off Time	','Total running hours','Total idle hours'
	   ];
	}
}
