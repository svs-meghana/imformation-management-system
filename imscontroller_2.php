<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\input;
use ZipArchive;
use PDFMerger;


class imscontroller_2 extends Controller
{
    public function verifylogin(Request $request)
    {
        $name=$request->input('userid');
        $pass=$request->input('password');
            $data= DB::select("select * from cen_admin where name='$name'");
            foreach ($data as $row)
            {
                $p1=$row->login_pass;
                if ($p1==$pass)
                {
                    $request->session()->put('name', $row->name);
                    return redirect('/home');
                }
            }
            //return redirect('/login'); 
              
        print_r($data);
    }

    public function responses(Request $req)
    {
        $x=DB::select("select * from requests");
        $completed = array();
        $incompleted = array();
        //echo "completed request<br>";
        foreach($x as $d){
            $id=$d->{'req_id'};
            $data=DB::select("select req_id,count(*) as c from req_status where req_id=".$id." and rep_content!='None' group by req_id;");
     
            if(sizeOf($data)!=0 and $d->{'count_n'}==$data[0]->{'c'})
            {
                array_push($completed,$d);
           
            }
            
        }
        //echo "pending request<br>";
        foreach($x as $d){
            $id=$d->{'req_id'};
            $data=DB::select("select req_id,count(*) as c from req_status where req_id=".$id." and rep_content='None' group by req_id;");
            
            

            if(sizeOf($data)!=0)
            {
                array_push($incompleted,$d);
           
            }
        }
        return view('home')->with( array('completed'=>$completed, 'incompleted'=>$incompleted) );
    }
    public function view_files(Request $req)
    {
        $id=$req->input('req_id');
        #echo $id."<br>";
        $data=DB::select('select * from req_status where req_id='.$id);
        #print_r($data);
        return view('home')->with( array('view_files'=>$data));
    }

    public function mail_sent()
    {
        $data=DB::select("select * from req_status where rep_content='None'");
       // print_r($data);
        set_time_limit(3000); 
        /* connect to gmail with your credentials */
        $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $username = 'ims.knightcoders@gmail.com'; 
        $password = 'K1ngd00m';
        /* try to connect */
        $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
        $emails = imap_search($inbox, 'ALL');
        /* if any emails found, iterate through each email */
        if($emails) 
        {
            $count = 1;
            /* put the newest emails on top */
            rsort($emails);
            /* for every email... */
            foreach($emails as $email_number) 
            {
                /* get information specific to this email */
                $overview = imap_fetch_overview($inbox,$email_number,0);
                $headerInfo = imap_headerinfo($inbox,$email_number);
                $message = imap_fetchbody($inbox,$email_number,2);
                /* get mail structure */
                $structure = imap_fetchstructure($inbox, $email_number);
                $attachments = array();
                /* if any attachments found... */
                if(isset($structure->parts) && count($structure->parts)) 
                {
                    for($i = 0; $i < count($structure->parts); $i++) 
                    {
                        $attachments[$i] = array(
                        'is_attachment' => false,
                        'filename' => '',
                        'name' => '',
                        'attachment' => '',
                        'subject'=>'',
                        'email'=>''
                        );
                        if($structure->parts[$i]->ifdparameters) 
                        {
                            foreach($structure->parts[$i]->dparameters as $object) 
                            {
                                if(strtolower($object->attribute) == 'filename') 
                                {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['filename'] = $object->value;
                                }
                            }
                        }
                        if($structure->parts[$i]->ifparameters) 
                        {
                            foreach($structure->parts[$i]->parameters as $object) 
                            {
                                if(strtolower($object->attribute) == 'name') 
                                {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['name'] = $object->value;
                                }
                            }
                        }
                        if($attachments[$i]['is_attachment']) 
                        {
                            $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);
                            /* 3 = BASE64 encoding */
                            if($structure->parts[$i]->encoding == 3) 
                            { 
                                $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                            }
                            /* 4 = QUOTED-PRINTABLE encoding */
                            elseif($structure->parts[$i]->encoding == 4) 
                            { 
                                $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                            }
                        }
                        if(!empty($headerInfo->subject))
                        {
                            $attachments[$i]['subject']=$headerInfo->subject;
                        }
                        if(!empty($headerInfo->from[0]->{'mailbox'}) && !empty($headerInfo->from[0]->{'host'}))
                        $attachments[$i]['email']=$headerInfo->from[0]->{'mailbox'}.'@'.$headerInfo->from[0]->{'host'};
                    }
                }
                /* iterate through each attachment and save it */
                foreach($attachments as $attachment)
                {
                    if($attachment['is_attachment'] == 1)
                    {
                        $filename = $attachment['name'];
                        if(empty($filename)) $filename = $attachment['filename'];
                        if(empty($filename)) $filename = time() . ".dat";
                        $fp = fopen("H:/xampp/htdocs/ims1/attachments/". $filename, "w+");
                       
                        fwrite($fp, $attachment['attachment']);
                        fclose($fp);
                        foreach($data as $d)
                        {
                            $matches = array();
                            preg_match("/(#[1-9][0-9]*)/",$attachment['subject'],$matches);
                            if((sizeof($matches)!=0 && $matches[0]=='#'.$d->{'req_id'}) || $attachment['subject']=='Re: #'.$d->{'req_id'} )
                            {
                                $file1=$attachment['filename'];
                                $email1=$attachment['email'];
                                $x=DB::update("update req_status set rep_content='$file1' where req_id=".$d->{'req_id'}." and to_mail='$email1'");
                            }
                        }
                        
                    }
                }
            }
    
        }    
        /* close the connection */
        imap_close($inbox);
        //echo "all attachment Downloaded";
        return view('home');
    }        
    public function download_files(Request $req)
    {
        $id=$req->input('req_id1');
        $data=DB::select('select distinct rep_content from req_status where req_id='.$id.';');
        #print_r($data);
        $arr=array();
        foreach($data as $d)
        {
            array_push($arr,$d->{'rep_content'});
        }
        //print_r($arr);
        $arr1=$this->pdfmerge($arr);
        print_r($arr1);
        $zip = new ZipArchive();
         //create the file and throw the error if unsuccessful
        $archive_file_name=time().".zip";
        $file_path="H:/xampp/htdocs/ims1/attachments/";
	    if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
    	    exit("cannot open <$archive_file_name>");
	    }
	    //add each files of $file_name array to archive
	    foreach($arr1 as $files)
	    {
  		    $zip->addFile($file_path.$files,$files);
		    //echo $file_path.$files,$files."
        }
	    $zip->close();
        //then send the headers to foce download the zip file
        header("Content-type: application/zip"); 
	    header("Content-Disposition: attachment; filename=$archive_file_name"); 
	    header("Pragma: no-cache"); 
	    header("Expires: 0"); 
	    readfile("$archive_file_name");
    }
    public function pdfmerge($arr)
    {
        //print_r($arr);
        $y=array();
        $dir='H:/xampp/htdocs/ims1/attachments/';
        foreach($arr as $a)
        {
            if($a!='None'){
            $x=new \Symfony\Component\HttpFoundation\File\File($dir.$a);
            array_push($y,$x);
            }
        }
        //print_r($y);
        $pdf=new PDFMerger();
        $newarr=array();
        $c=0;
        foreach($y as $file)
        {

            $extension=$file->getExtension();
            if($extension=='pdf')
            {
                $filepath=$file->getPathName();
                $pdf->addPDF($filepath,'all');
            }
            else{
                array_push($newarr,$arr[$c]);
            }
            $c++;
        }
        $filename=time().'.pdf';
        $pathForTheMergedPdf='H:/xampp/htdocs/ims1/attachments/'.$filename;
        $pdf->merge('file', $pathForTheMergedPdf);
        array_push($newarr,$filename);
        return $newarr;
    }
    public function profile(Request $req)
    {
        $x=$req->session()->get('uid');
        return view('edit-profile')->with(array('x'=>$x));
    } 
    public function logout(Request $req)
    {
        return redirect('login');
    }

    public function statistics(Request $req)
    {
        $statistics = array();
        $reqs = DB::select("select count(*) as cnt from requests");
        $statistics['Total_Requests'] = $reqs[0]->{'cnt'};

        $comp_reqs = DB::select("select count(*) as cnt from requests r where count_n=(select count(*) from req_status where req_id=r.req_id)");
        $statistics['Completed_Requests'] = $comp_reqs[0]->{'cnt'};

        $statistics['Pending_Requests'] = $statistics['Total_Requests'] - $statistics['Completed_Requests'];

        $resps = DB::select("select count(*) as cnt from req_status");
        $statistics['Total_Responses'] = $resps[0]->{'cnt'};

        $resps = DB::select("select count(*) as cnt from req_status r where rep_content!='None'");
        $statistics['Responses_Received'] = $resps[0]->{'cnt'};
        return view('home')->with(array('statistics'=>$statistics));
    }
    public function home1(Request $r)
    {
        $s='The Ministry of Statistics and Programme Implementation attaches considerable importance to coverage and quality aspects of statistics released in the country. The statistics released are based on administrative sources, surveys and censuses conducted by the center and State Governments and non-official sources and studies. The surveys conducted by the Ministry are based on scientific sampling methods. Field data are collected through dedicated field staff. In line with the emphasis on the quality of statistics released by the Ministry, the methodological issues concerning the compilation of national accounts are overseen Committees like Advisory Committee on National Accounts, Standing Committee on Industrial Statistics, Technical Advisory Committee on Price Indices. The Ministry compiles data sets based on current data, after applying standard statistical techniques and extensive scrutiny and supervision.';
        return view('home')->with(array('home_data'=>$s));
    }
}
