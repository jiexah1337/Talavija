<?php
namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Illuminate\Http\Request;
use DB;
use Sentinel;
use App\Models\PermissionList;
class gCalendarController extends Controller
{
    protected $client;
    public $permissionList;

    public function __construct()
    {
        $this->permissionList = new PermissionList();

        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR);

        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
        $client->setHttpClient($guzzleClient);
        $this->client = $client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        session_start();

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);

            $calendarId = 'primary';

            $optParams = array(
                'maxResults' => 10,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date('c'),
            );
            $results = $service->events->listEvents($calendarId,$optParams);
//			fullcalendar_friendly_data_construction
            $events=$results->getItems();
            $data=[];
            foreach($events as $event){
                $subArr=[
                    'id'=>$event->id,
                    'title'=>$event->getSummary(),
                    'start_date'=>$event->getStart()->getDateTime(),
                    'end_date'=>$event->getEnd()->getDateTime()
                ];
                array_push($data,$subArr);
            }
            return $results->getItems();

        } else {
            return redirect()->route('oauthCallback');
        }

    }

    public function oauth()
    {
        session_start();

        $rurl = action('gCalendarController@oauth');
        $this->client->setRedirectUri($rurl);
        if (!isset($_GET['code'])) {
            $auth_url = $this->client->createAuthUrl();
            $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
            return redirect($filtered_url);
        } else {
            $this->client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->client->getAccessToken();
            return redirect()->route('cal.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(Sentinel::getUser()->hasAccess('calendar.event-access')){
            return view('calendar.createEvent');
        }
        return redirect(route('accessDenied'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        session_start();

        $important = $request->event_important;
        $groups = $request->for_groups;
        $title = $request->title;
        $description = $request->description;
        if (isset($_POST['event_important'])) {
            $check=true;
            $obligats="(Apmeklejums obligats prieks gruppam : " .$groups .")";

            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'jiexah1337@gmail.com';                 // SMTP username
                $mail->Password = '';                          // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('jiexah1338@gmail.com', 'Talavija');
                $mail->addAddress('a.rodnovs@inbox.lv');               // Name is optional
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $title;
                $mail->Body    = $description;
                $users=DB::table('user_statuses')->get();
                // parsejam prieks ka bus events string piemers(z!, fil!) bus masivs array[0] = "z1" array[1] = "fil!" charlist ! nozime ka ! apstradat ka burtu
                $array=str_word_count($groups, 1, '!');
                $i=0;
                // foreach lai dabut status id no statusa abbriviaturas un ieraksta to masiva
                foreach ($array as $value) {

                    $statusid = DB::table('statuses')->where('abbreviation', '=', $value)->value('id');
                    $statusidarray[$i]=$statusid;
                    $i++;
                }
                $i=0;
                // foreach lai dabut lietotaju srakstus kuriem ir status no augsaja foreach
                foreach($statusidarray as $value){
                    $users[$i] = DB::table('user_statuses')->Where('status_id', '=', $value)->pluck('member_id');
                    $i++;
                }
                //atradam emailus useriem un sutam epastus
                for($i = 0; $i < count($users); $i++) {

                    foreach ($users[$i] as $value) {
                        $email = DB::table('users')->where('member_id', '=', $value)->value('email');
                        echo $email;
                        echo "   ";
                        $mail->addAddress($email);
                        $mail->send();
                    }
                }

                //Content

                //echo 'Message has been sent';
            } catch (Exception $e) {
                // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }

            // Checkbox is selected
        } else {
            $check=false;
            $obligats="neobligati";
            // Checkbox isn't selected =)
        }
        $startDateTime = $request->start_date;
        $endDateTime = $request->end_date;

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);
            $calendarId = 'primary';
            $event = new Google_Service_Calendar_Event([
                'summary' => $title.$obligats,
                'description' => $description,

                'start' => array(
                    'dateTime' => $startDateTime,
                    'timeZone' => 'Europe/Riga',
                ),
                'end' => array(
                    'dateTime' => $endDateTime,
                    'timeZone' => 'Europe/Riga',
                ),

                'reminders' => ['useDefault' => true],
            ]);
            $results = $service->events->insert($calendarId, $event);
       if (!$results) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'message' => 'Event Created']);
        } else {
            return redirect()->route('oauthCallback');
        }



    }

    /**
     * Display the specified resource.
     *
     * @param $eventId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($eventId)
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);

            $service = new Google_Service_Calendar($this->client);
            $event = $service->events->get('primary', $eventId);

            if (!$event) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'data' => $event]);

        } else {
            return redirect()->route('oauthCallback');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $eventId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, $eventId)
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);

            $startDateTime = Carbon::parse($request->start_date)->toRfc3339String();

            $eventDuration = 30; //minutes

            if ($request->has('end_date')) {
                $endDateTime = Carbon::parse($request->end_date)->toRfc3339String();

            } else {
                $endDateTime = Carbon::parse($request->start_date)->addMinutes($eventDuration)->toRfc3339String();
            }

            // retrieve the event from the API.
            $event = $service->events->get('primary', $eventId);

            $event->setSummary($request->title);

            $event->setDescription($request->description);

            //start time
            $start = new Google_Service_Calendar_EventDateTime();
            $start->setDateTime($startDateTime);
            $event->setStart($start);

            //end time
            $end = new Google_Service_Calendar_EventDateTime();
            $end->setDateTime($endDateTime);
            $event->setEnd($end);

            $updatedEvent = $service->events->update('primary', $event->getId(), $event);


            if (!$updatedEvent) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'data' => $updatedEvent]);

        } else {
            return redirect()->route('oauthCallback');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $eventId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy($eventId)
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);

            $service->events->delete('primary', $eventId);

        } else {
            return redirect()->route('oauthCallback');
        }
    }
}