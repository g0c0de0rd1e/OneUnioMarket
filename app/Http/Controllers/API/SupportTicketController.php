<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SupportTicketService;
use Exception;
use Illuminate\Http\Request;
use Modules\SupportTicket\Entities\SupportTicketFile;
use Modules\SupportTicket\Entities\TicketMessage;
use Modules\SupportTicket\Entities\TicketMessageFile;
use Modules\SupportTicket\Repositories\SupportTicketCategoryRepository;
use Modules\SupportTicket\Repositories\TicketPriorityRepository;

/**
* @group Support Ticket
*
* APIs for support ticket
*/

class SupportTicketController extends Controller
{
    protected $supportTicketService;

    public function __construct(SupportTicketService $supportTicketService)
    {
        $this->supportTicketService = $supportTicketService;
    }

    /**
     * Ticket List
     * @response{
     *      "tickets": {
     *           "current_page": 1,
     *           "data": [
     *               {
     *                   "id": 5,
     *                   "reference_no": "124612",
     *                   "subject": "test ticket 222",
     *                   "description": "descriptiuon",
     *                   "category_id": 3,
     *                   "priority_id": 2,
     *                   "user_id": 4,
     *                   "refer_id": null,
     *                   "status_id": 1,
     *                   "created_at": "2021-09-14T04:43:32.000000Z",
     *                   "updated_at": "2021-09-14T07:19:07.000000Z"
     *               },
     *               {
     *                   "id": 7,
     *                   "reference_no": "TIC781078",
     *                   "subject": "hello test 21",
     *                   "description": "<p>testjhsakjkajskd</p>",
     *                   "category_id": 2,
     *                   "priority_id": 2,
     *                   "user_id": 4,
     *                   "refer_id": null,
     *                   "status_id": 1,
     *                   "created_at": "2021-09-20T09:44:38.000000Z",
     *                   "updated_at": "2021-09-20T09:44:38.000000Z"
     *               }
     *           ],
     *           "first_page_url": "http://ecommerce.test/api/ticket-list?page=1",
     *           "from": 1,
     *           "last_page": 1,
     *           "last_page_url": "http://ecommerce.test/api/ticket-list?page=1",
     *           "links": [
     *               {
     *                   "url": null,
     *                   "label": "&laquo; Previous",
     *                   "active": false
     *               },
     *               {
     *                   "url": "http://ecommerce.test/api/ticket-list?page=1",
     *                   "label": "1",
     *                   "active": true
     *               },
     *               {
     *                   "url": null,
     *                   "label": "Next &raquo;",
     *                   "active": false
     *               }
     *           ],
     *           "next_page_url": null,
     *           "path": "http://ecommerce.test/api/ticket-list",
     *           "per_page": 10,
     *           "prev_page_url": null,
     *           "to": 2,
     *           "total": 2
     *       },
     *       "statuses": [
     *           {
     *               "id": 1,
     *               "name": "Pending",
     *               "isActive": 0,
     *               "status": 1,
     *               "created_at": "2021-08-08T04:03:54.000000Z",
     *               "updated_at": "2021-08-08T04:03:54.000000Z"
     *           },
     *           {
     *               "id": 2,
     *               "name": "On Going",
     *               "isActive": 0,
     *               "status": 1,
     *               "created_at": "2021-08-08T04:03:55.000000Z",
     *               "updated_at": "2021-08-08T04:03:55.000000Z"
     *           },
     *           {
     *               "id": 3,
     *               "name": "Completed",
     *               "isActive": 0,
     *               "status": 1,
     *               "created_at": "2021-08-08T04:03:55.000000Z",
     *               "updated_at": "2021-08-08T04:03:55.000000Z"
     *           },
     *           {
     *               "id": 4,
     *               "name": "Closed",
     *               "isActive": 0,
     *               "status": 1,
     *               "created_at": "2021-08-08T04:03:55.000000Z",
     *               "updated_at": "2021-08-08T04:03:55.000000Z"
     *           }
     *       ],
     *       "msg": "success"
     * }
     */
    
    public function index(Request $request){
        $tickets = $this->supportTicketService->getMyTickets($request->user()->id);
        $statuses = $this->supportTicketService->getStatuses();

        return response()->json([
            'tickets' => $tickets,
            'statuses' => $statuses,
            'msg' => 'success'
        ], 200);
    }

    /**
     * Get Ticket with paginate
     * @urlParam status integer required id of status
     * @urlParam page integer required page number
     * @response{
     *       "tickets": {
     *           "current_page": 1,
     *           "data": [
     *               {
     *                   "id": 5,
     *                   "reference_no": "124612",
     *                   "subject": "test ticket 222",
     *                   "description": "<h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-weight: 400; font-family: DauphinPlain; font-size: 24px; line-height: 24px; color: rgb(0, 0, 0); background-color: rgb(255, 255, 255);\">What is Lorem Ipsum?</h2><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; background-color: rgb(255, 255, 255);\"><strong style=\"margin: 0px; padding: 0px;\">Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>",
     *                   "category_id": 3,
     *                   "priority_id": 2,
     *                   "user_id": 4,
     *                   "refer_id": null,
     *                   "status_id": 1,
     *                   "created_at": "2021-09-14T04:43:32.000000Z",
     *                   "updated_at": "2021-09-14T07:19:07.000000Z"
     *               },
     *               {
     *                   "id": 7,
     *                   "reference_no": "TIC781078",
     *                   "subject": "hello test 21",
     *                   "description": "<p>testjhsakjkajskd</p>",
     *                   "category_id": 2,
     *                   "priority_id": 2,
     *                   "user_id": 4,
     *                   "refer_id": null,
     *                   "status_id": 1,
     *                   "created_at": "2021-09-20T09:44:38.000000Z",
     *                   "updated_at": "2021-09-20T09:44:38.000000Z"
     *               }
     *           ],
     *           "first_page_url": "http://ecommerce.test/api/ticket-list-get-data?page=1",
     *           "from": 1,
     *           "last_page": 1,
     *           "last_page_url": "http://ecommerce.test/api/ticket-list-get-data?page=1",
     *           "links": [
     *               {
     *                   "url": null,
     *                   "label": "&laquo; Previous",
     *                   "active": false
     *               },
     *               {
     *                   "url": "http://ecommerce.test/api/ticket-list-get-data?page=1",
     *                   "label": "1",
     *                   "active": true
     *               },
     *               {
     *                   "url": null,
     *                   "label": "Next &raquo;",
     *                   "active": false
     *               }
     *           ],
     *           "next_page_url": null,
     *           "path": "http://ecommerce.test/api/ticket-list-get-data",
     *           "per_page": 10,
     *           "prev_page_url": null,
     *           "to": 2,
     *           "total": 2
     *       },
     *       "statuses": [
     *           status list
     *       ],
     *       "msg": "success"
     * }
     */

    public function getTicketsWithPaginate(Request $request){
        $status = null;
        $page = null;
        if(isset($request->status)){
            $status = $request->status;
        }
        if(isset($request->page)){
            $page = $request->page;
        }

        $tickets = $this->supportTicketService->getMyTicketWithPaginate(['page'=>$page, 'status' => $status, 'user_id' => $request->user()->id]);
        $statuses = $this->supportTicketService->getStatuses();

        return response()->json([
            'tickets' => $tickets,
            'statuses' => $statuses,
            'msg' => 'success'
        ], 200);

    }

    /**
     * Ticket Store
     * @bodyParam subject string required subject
     * @bodyParam ticket_file string required example: type array
     * @bodyParam category_id integer required example: 2
     * @bodyParam priority_id integer required example: 1
     * @bodyParam description string required ticket description
     * @response{
     *  'msg' => 'created successfully'
     * }
     */

    public function store(Request $request){
        $request->validate([
            'subject' => 'required|max:255',
            'ticket_file.*' => 'nullable|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
            'category_id' => 'required',
            'priority_id' => 'required',
            'description' => 'required',
        ]);

        $supportTicket = $this->supportTicketService->store($request->except('_token'), $request->user()->id);

        $files = $request->file('ticket_file');

        if($request->hasFile('ticket_file'))
        {
            if (!file_exists('uploads/support_ticket')) {
                mkdir('uploads/support_ticket', 0777, true);
            }
            foreach ($files as $file) {
                 $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('uploads/support_ticket/', $fileName);
                $filePath = 'uploads/support_ticket/' . $fileName;


                $ticketFile = new SupportTicketFile();
                $ticketFile->attachment_id = $supportTicket->id;
                $ticketFile->url = $filePath;
                $ticketFile->name = $file->getClientOriginalName();
                $ticketFile->type = $file->getClientOriginalExtension();
                $supportTicket->attachFiles()->save($ticketFile);

            }
        }

        return response()->json([
            'msg' => 'created successfully'
        ],201);

    }

    /**
     * Single Ticket
     * @urlParam ticket_number string required example: TIC781078
     * @response{
     *      "ticket": {
     *           "id": 7,
     *           "reference_no": "TIC781078",
     *           "subject": "hello test 21",
     *           "description": "<p>testjhsakjkajskd</p>",
     *           "category_id": 2,
     *           "priority_id": 2,
     *           "user_id": 4,
     *           "refer_id": null,
     *           "status_id": 1,
     *           "created_at": "2021-09-20T09:44:38.000000Z",
     *           "updated_at": "2021-09-20T09:44:38.000000Z"
     *       },
     *       "msg": "success"
     * }
     */

    public function show($id){
        $ticket = $this->supportTicketService->getTicketById($id);
        if($ticket){
            return response()->json([
                'ticket' => $ticket,
                'msg' => 'success'
            ],200);
        }else{
            return response()->json([
                'msg' => 'not found'
            ]);
        }
    }

    /**
     * Category List
     * @response{
     *      "categories": [
     *           {
     *               "id": 1,
     *               "name": "Installation",
     *               "status": 1,
     *               "created_at": "2021-08-08T04:03:54.000000Z",
     *               "updated_at": "2021-08-08T04:03:54.000000Z"
     *           },
     *           {
     *               "id": 2,
     *               "name": "Technical",
     *               "status": 1,
     *               "created_at": "2021-08-08T04:03:54.000000Z",
     *               "updated_at": "2021-08-08T04:03:54.000000Z"
     *           },
     *           {
     *               "id": 3,
     *               "name": "Others",
     *               "status": 1,
     *               "created_at": "2021-08-08T04:03:54.000000Z",
     *               "updated_at": "2021-08-08T04:03:54.000000Z"
     *           }
     *       ],
     *       "msg": "success"
     * }
     */

    public function categoryList(){
        $categoryRepo = new SupportTicketCategoryRepository();
        $categories = $categoryRepo->getActiveAll();
        return response()->json([
            'categories' => $categories,
            'msg' => 'success'
        ], 200);
    }

    /**
     * Priority List
     * @response{
     *      "priorities": [
     *           {
     *               "id": 1,
     *               "name": "High",
     *               "status": 1,
     *               "created_at": "2021-08-08T04:03:54.000000Z",
     *               "updated_at": "2021-08-08T04:03:54.000000Z"
     *           },
     *           {
     *               "id": 2,
     *               "name": "Medium",
     *               "status": 1,
     *               "created_at": "2021-08-08T04:03:54.000000Z",
     *               "updated_at": "2021-08-08T04:03:54.000000Z"
     *           },
     *           {
     *               "id": 3,
     *               "name": "Low",
     *               "status": 1,
     *               "created_at": "2021-08-08T04:03:54.000000Z",
     *               "updated_at": "2021-08-08T04:03:54.000000Z"
     *           }
     *       ],
     *       "msg": "success"
     * }
     */
    public function priorityList(){
        $priorityRepo = new TicketPriorityRepository();
        $priorities = $priorityRepo->getActiveAll();
        return response()->json([
            'priorities' => $priorities,
            'msg' => 'success'
        ], 200);
    }

    /**
     * Ticket Reply
     * @bodyParam text string required example: description
     * @bodyParam ticket_id integer required example: ticket id
     * @bodyParam ticket_file string required example: type array
     * @response{
     *      'msg' => 'Reply done.'
     * }
     */

    public function replyTicket(Request $request){
        $request->validate([
            'text' => 'required',
            'ticket_id' => 'required|numeric',
            'ticket_file.*' => 'nullable|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,sql',
            'status_id' => 'nullable'
        ]);

        try{
            $ticket_id = $request->input('ticket_id');
            if ($request->text != '') {
                $ticketMessage = TicketMessage::create([
                    'ticket_id' => $ticket_id,
                    'text'      => $request->input('text'),
                    'user_id' => auth()->user()->id,
                    'type' => $request->type
                ]);


                if ($request->hasFile('ticket_file')) {

                    if (!file_exists(asset_path('uploads/message_ticket_image/'))) {
                        mkdir(asset_path('uploads/message_ticket_image/'), 0777, true);
                    }

                    $files = $request->file('ticket_file');
                    foreach ($files as $file) {
                        $file_original_name = $file->getClientOriginalName();
                        $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $file->move(asset_path('uploads/message_ticket_image/'), $fileName);
                        $filePath = 'uploads/message_ticket_image/' . $fileName;

                        $messageFile = new TicketMessageFile();
                        $messageFile->message_id = $ticketMessage->id;
                        $messageFile->url = $filePath;
                        $messageFile->name = $file->getClientOriginalName();
                        $messageFile->type = $file->getClientOriginalExtension();
                        $messageFile->save();
                    }
                }
            }
            return response()->json([
                'msg' => 'Reply done.'
            ],201);

        }catch(Exception $e){
            return response()->json([
                'msg' => 'Something Went Wrong.'
            ],500);
        }
    }
}
