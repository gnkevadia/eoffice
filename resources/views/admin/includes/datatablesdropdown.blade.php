@php
    $arrActionUrls = [ 
        $action_url.'/add',
		$action_url.'/edit',
        $action_url.'/view',
        $action_url.'/toggle',
        $action_url.'/delete',
        $action_url.'/export',
        $action_url.'/order',
        $action_url.'/copy',
    ];    
@endphp    

@if(count(array_intersect($arrActionUrls, Session::get('routes'))) > 0)
    @if(in_array($action_url.'/add',Session::get('routes')))
        <button type="button" class="btn btn-brand btn-icon-sm" _data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <a href="{{ url($action_url.'/add') }}" class="kt-nav__link" style="color:#ffffff"><i class="flaticon2-plus"></i> Add New</a>
        </button>
    @endif
    @if(in_array($action_url.'/import',Session::get('routes')))
        <button type="button" class="btn btn-brand btn-icon-sm" _data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <a href="{{ url($action_url.'/import') }}" class="kt-nav__link" style="color:#ffffff"><i class="icon-2x text-dark-50 flaticon-upload"></i> Import</a>
        </button>
    @endif
    <script>
        isViewStatus = false;
        isChangeStatus = false;
        isUpdateStatus = false;
        isDeleteStatus = false;
        isExportStatus = false;
        isOrderStatus = false;
        isCopyStatus = false;
    </script>
    @if(in_array($action_url.'/view',Session::get('routes')))
    <script>
        isViewStatus = true;
        viewURL = '<?php echo $action_url;?>'+'/view';
    </script>
    @endif
    @if(in_array($action_url.'/toggle',Session::get('routes')))
    <script>
        isChangeStatus = true;
        toggleURL = '<?php echo $action_url;?>'+'/toggle';
    </script>
    @endif
    @if(in_array($action_url.'/edit',Session::get('routes')))
    <script>
        isUpdateStatus = true;
        editURL = '<?php echo $action_url;?>'+'/edit';
    </script>
    @endif
    @if(in_array($action_url.'/delete',Session::get('routes')))
    <script>
        isDeleteStatus = true;
        deleteURL = '<?php echo $action_url;?>'+'/delete';
    </script>
    @endif
    @if(in_array($action_url.'/export',Session::get('routes')))
    <script>
        isExportStatus = true;
        exportURL = '<?php echo $action_url;?>'+'/export';
    </script>
    @endif
    @if(in_array($action_url.'/order',Session::get('routes')))
    <script>
        isOrderStatus = true;
        orderURL = '<?php echo $action_url;?>'+'/order';
    </script>
    @endif
    @if(in_array($action_url.'/copy',Session::get('routes')))
    <script>
        isCopyStatus = true;
        copyURL = '<?php echo $action_url;?>'+'/copy';
    </script>
    @endif
    @if(in_array($action_url.'/import',Session::get('routes')))
    <script>
        isCopyStatus = true;
        copyURL = '<?php echo $action_url;?>'+'/import';
    </script>
    @endif
@endif