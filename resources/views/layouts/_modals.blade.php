{{-- Student Search Modal --}}
<div class="modal fade" id="searchStudentModal" tabindex="-1" role="dialog" aria-labelledby="searchStudentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-center">

            <div class="modal-body">
                <div class="topbar-search-student-wrapper">
                    <div id="topbar_search_student_hint">Type and hit Enter</div>
                    <input type="text" name="topbar_search_student" id="topbar_search_student" class="form-control" placeholder="Student Name / Reg. No." />
                </div>
                <div id="searchStudentResult"></div>
            </div>
        </div>
    </div>
</div>

{{-- Success Modal --}}
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center">

            <div class="modal-body">
                <div class="checkmark-image">
                    <img src="{{ asset('media/ojeel/checkmark.gif') }}" />
                </div>
                <div id="successModalContent"></div>
                <div id="successModalBtns" class="modal-btns">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Common Modal --}}
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center">

            <div class="modal-body">
                <div id="commonModalContent"></div>
                <div id="commonModalBtns" class="modal-btns">
                    <button type="button" id="commonModal_close_btn" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Set Campus Modal --}}
<div class="modal fade" id="setCampusModal" tabindex="-1" role="dialog" aria-labelledby="setCampusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center">

            <div class="modal-body">
                <div id="setCampusModalContent"></div>
            </div>
        </div>
    </div>
</div>
