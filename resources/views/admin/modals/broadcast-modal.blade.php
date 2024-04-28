<!-- Modal -->
<div class="modal fade" id="broadcastModal" tabindex="-1" role="dialog" aria-labelledby="broadcastModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="broadcastModalLabel">Send new message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="message d-block text-center"> </span>
                <div class="">
                    <input class="w-100 form-control rounded-0" 
                    id="searchUser" 
                    name="search" 
                    placeholder="Search options">
                    <span class="error"> </span>
                </div>
                <div class="mt-2 position-relative">
                    <select class="w-100 form-control rounded-0" id="recipient" name="recipient">
                        <option value="all" data-email="">All</option>
                    </select>
                    <span class="position-absolute bg-white px-1" style="top:-10px;left:20px;font-size:12px;">Recipients</span>
                </div>
                <div class="mt-2">
                    <input class="w-100 form-control rounded-0" 
                    name="email" readonly
                    placeholder="Email...">
                </div>
                <div class="mt-2">
                    <h4 class="fw-semibold d-flex">
                        <div class="mr-1">Title</div> 
                        <div style="margin-top:-3px"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/><path d="m15 5 3 3"/></svg></div>
                    </h4>
                </div>
                <div class="mt-2">
                    <input class="w-100 form-control rounded-0" 
                    maxlength="40"
                    name="title" 
                    placeholder="title">
                    <span class="error"> </span>
                </div>
                <div class="mt-2">
                    <textarea class="w-100 form-control rounded-0" 
                    maxlength="200"
                    style="height:150px;" 
                    name="message" 
                    placeholder="message"></textarea>
                    <span class="error"> </span>
                </div>
                <div class="mt-2">
                    <button type="button"
                    data-url="{{url('/api/admin/user/send-push-notification')}}"
                    class="btn btn-primary rounded-0 w-100 fw-bolder" 
                    id="send">Send Now</button>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End of Modal -->