<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Mail;
class imscontroller_1 extends Controller
{
    public function selectMails(Request $req){ //adds req_des AND DEADLINE TO DB

        // $data = DB::select("select * from requests where req_id = $id");
        // $req_content = $data[0]->{'req_content'};
        // $deadline = $data[0]->{'deadline'};
        // $deadline = strtotime($deadline);
        // $deadline = date('d/m/Y H:i',$deadline);
        // $requester = $data[0]->{'uid'};
        $in = $req->input();
        //print_r($in);
        $subject = $in['req_content'];
        $deadline = $in['deadline'];
        $requester = $in['requester'];
        $body = $in['req_content_body'];
        $destination='H:/xampp/htdocs/ims1/uploads/';
        $input = Input::all();
        $file = array_get($input,'attachment');
        $name=$file->getClientOriginalName();
        //echo $name;
        $file->move($destination,$name); 
        DB::insert("insert into requests(req_by,deadline,description,body,attachment) values('$requester','$deadline','$subject','$body', '$name')");
        $req_ids = DB::select("select req_id from requests where description='$subject' and req_by='$requester' and deadline='$deadline'");
        $req_id = $req_ids[0]->{'req_id'};
        $req_info = array('req_id'=>$req_id,
        'subject'=>$subject,
        'deadline'=>$deadline,
        'requester'=>$requester,
        'body'=>$body,
        'attachment'=>$file);
        
        $divisions = DB::select("select * from division");
        $div_emps = array();
        $div_names = array();
        $div_ids = array();
        foreach($divisions as $div){
            $div_name = $div->{'dname'};
            $div_id = $div->{'div_id'};
            array_push($div_names,$div_name);
            array_push($div_ids,$div_id);
            $emps = DB::select("select * from officer_details where div_id='$div_id'");
            $e  = array();
            foreach($emps as $emp){
                $tuple = array($emp->{'officer_id'},$emp->{'o_name'});
                array_push($e, $tuple);
            }
            array_push($div_emps,$e);
        }

        //print_r($divisions);

        return view('selectEmps')->with( array(
        'req_info'=>$req_info,
        'div_ids'=>$div_ids,
        'div_names'=>$div_names,
        'div_emps'=>$div_emps));
    }

    public function addEmps(Request $req){ // adds emps to mail in DB and sends mail.
        $in = $req->input();
        $subject = $in['subject'];
        $body = $in['body'];
        $req_id = $in['req_id'];
        $deadline = $in['deadline'];
        $requester = $in['requester'];
        $input = Input::all();
        $file = array_get($input,'attachment');
        $count_n=0;
        $req_info = array(
            'req_id'=>$req_id,
            'subject'=>$subject,
            'deadline'=>$deadline
            //'requester'=>$requester
        );
        //print_r($in);
        $divs = DB::select("select * from division");

        $div_emps = array();
        $div_names = array();
        $div_ids = array();
        foreach($divs as $div){
            $div_name = $div->{'dname'};
            $div_id = $div->{'div_id'};
            array_push($div_names,$div_name);
            array_push($div_ids,$div_id);
            $emps = DB::select("select * from officer_details where div_id='$div_id'");
            $e  = array();
            foreach($emps as $emp){
                $tuple = array($emp->{'officer_id'},$emp->{'o_name'});
                array_push($e, $tuple);
            }
            array_push($div_emps,$e);
        }

        $reqs = DB::select("select * from requests where req_id=$req_id");
        $fname = $reqs[0]->{'attachment'};
        $e = array();
        $d = array();
        foreach($divs as $div){
           if( isset($in[$div->{'dname'}]) ){
               $e2 = $in[$div->{'dname'}]; 
            // array_push($e,$in['division'.$div->{'div_id'}]);
            //array_push($d,$div->{'div_id'});
                foreach($e2 as $e1){
                
                    $div_id = $div->{'div_id'};
                    $mails = DB::select("select * from officer_details where officer_id='$e1'");
                    $to_email = $mails[0]->{'mail_id'};
                    $to_name = $mails[0]->{'o_name'};
                    
                    DB::insert("insert into req_status values($req_id,'$to_email',0,'None','$e1')");
                    // $data = DB::select("select * from officer_details where div_id='$div_id' and officer_id='$e1'");
                    // $data2 = DB::select("select * from users where div_id='$div_id'");
                    // $uid = $data2[0]->{'uid'};
                    // //DB::insert("insert into admin_req values($req_id,'$uid','None','".$data[0]->{'mail_id'}."','".$data[0]->{'officer_id'}."')");
                    
                    $mailData = array('name'=>$to_name, "body" => $body,"requester"=>$requester,"req_id"=>$req_id,"mail"=>$to_email);
                    $r_id=$req_id;
                    Mail::send('emails.requestMail',$mailData, function($message) use ($to_name, $fname,$to_email,$req_id,$mails,$subject) {
                        $message->to($to_email, $to_name)
                        ->subject($subject.' #'.$req_id);
                        $message->attach('H:/xampp/htdocs/ims1/uploads/'.$fname);
                        $message->from('ims.knightcoders@gmail.com','Central Admin');
                    DB::update("update req_status set alert_to='".$mails[0]->{'officer_id'}."' where req_id= $req_id and to_mail='$to_email'");
                    });
                    //echo '<h1>CHECK YOUR MAIL</h1>';
                    $count_n++;
                    
                }
            }
        }
        //echo 'update '.$count_n;
        DB::update("update requests set count_n=$count_n where req_id=$req_id");
        // return view('selectAlertMails')->with( array(
        //     'req_info'=>$req_info,
        //     'div_ids'=>$div_ids,
        //     'div_names'=>$div_names,
        //     'div_emps'=>$div_emps));
        echo  'check mail';
    }

    public function addAlertMails(Request $req){
        $in = $req->input();
        $req_id = $in['req_id'];

        $divs = DB::select("select * from division");
        $e = array();
        $d = array();
        foreach($divs as $div){
           if(isset($in[$div->{'dname'}])){
                $e2 = $in[$div->{'dname'}];
                // array_push($e,$in['division'.$div->{'div_id'}]);
                //array_push($d,$div->{'div_id'});
                foreach($e2 as $e1){
                    if($e1 != 'None'){
                        $div_id = $div->{'div_id'};
                        $mails = DB::select("select * from officer_details where officer_id='$e1'");
                        $to_email = $mails[0]->{'mail_id'};
                        $to_name = $mails[0]->{'o_name'};
                        
                        DB::insert("insert into alert values($req_id,'$to_email')");
                        // $data = DB::select("select * from officer_details where div_id='$div_id' and officer_id='$e1'");
                        // $data2 = DB::select("select * from users where div_id='$div_id'");
                        // $uid = $data2[0]->{'uid'};
                        // //DB::insert("insert into admin_req values($req_id,'$uid','None','".$data[0]->{'mail_id'}."','".$data[0]->{'officer_id'}."')");
                        
                        /*$mailData = array('name'=>$to_name, "body" => $req_content,"req_id"=>$req_id);
                        $r_id=$req_id;
                        Mail::send('emails.requestMail', $mailData, function($message) use ($to_name, $to_email,$r_id) {
                            $message->to($to_email, $to_name)
                            ->subject('#'.$r_id);
                            $message->from('csemail105.105@gmail.com','Central Admin');
                        });
                        //echo '<h1>CHECK YOUR MAIL</h1>';
                        $count_n++;*/
                    }
                }
            }
        }
        echo 'check db';
        echo '<br> Added Successfully';
        return redirect('/home');
    }

    public function history(Request $req){
        $requests = DB::select("select * from requests");
        $reqs = array();
        foreach($requests as $req){
            $r = array();
            
            $r['req_id'] = $req->{'req_id'};
            $r['req_by'] = $req->{'req_by'};
            $r['deadline'] = $req->{'deadline'};
            $r['description'] = $req->{'description'};
            $c = DB::select("select count(*) as cnt from req_status where req_id=".$req->{'req_id'}." and rep_content!='None'");

            if($c[0]->{'cnt'} == $req->{'count_n'})
                $r['completed'] = 'Yes';
            else
                $r['completed'] = 'No';
            array_push($reqs,$r);
        }
        return view('home')->with(array('reqs'=>$reqs));
    }

    public function update(Request $req){
        $req_id = $req->input('req_id');
        $mail = $req->input('mail');
        DB::update("update req_status set has_seen=1 where req_id=$req_id and to_mail='$mail'");
        echo "THANKING YOU FOR VERIFYING ";
    }

}
