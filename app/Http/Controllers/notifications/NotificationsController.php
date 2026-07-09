<?php
namespace App\Http\Controllers\notifications;
use App\Http\Controllers\Controller;

use App\Models\Device;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function notifications(Request $request)
    {
        return view('hr.notifications_list');
    }
        public function get_pdf(Request $request)
    {
        $pdfName = 'http://localhost/track_order/storage/app/pdfs/abc.pdf';
        return view('service.pdf_download', compact('pdfName'));
    }

        public function downloadPdf($fileName)
    {

        $pdfName = storage_path('app/pdfs/'.$fileName);
        $deviceInfo = [
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
        // Store the device information in the database
        // Device::create([
        //     'file_name' => $fileName,
        //     'device_info' => json_encode($deviceInfo)
        // ]);

        // Check if the device information matches the stored information
        $storedDeviceInfo = Device::where('file_name', $fileName)->first();
        if ($storedDeviceInfo && $storedDeviceInfo->device_info == json_encode($deviceInfo)) {
            // Send the PDF file to the user
            return response()->download($pdfName);
        } else {
            // Return an error message
            return response()->json(['error' => 'Access denied for this device.']);
        }
    }
}
