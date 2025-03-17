</div>
<!-- /.card-footer -->
<!-- /.card-footer -->
</div>
<!-- /. card -->
</div>
<!-- /.col -->
</div>

<div class="modal fade" id="urlModal" tabindex="-1" role="dialog" aria-labelledby="urlModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="max-width: 600px;">
            <iframe id="urlModal_Frame" src="https://lic-ems.local/ems/messages/share?file=" height="600" title="Chia sẻ tới nhóm chat"></iframe>
        </div>
    </div>
</div>

<div class="modal fade" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="newFolderModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="newFolderModalLabel">New folder</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="new-folder">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" />
                    </div>
                    <input type="hidden" name="dir" value="{{ $url['path'] }}" />
                    {{ csrf_field() }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .modal-dialog {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100vw;
        height: 100vh;
        max-width: none !important;
    }

    .model-content {
        width: 500px;
        height: 400px;
        position: relative;
    }
</style>
