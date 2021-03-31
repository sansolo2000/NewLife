
@switch($menu)
    @case(1)
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">Todo</li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/2')}}">Jira HN</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/3')}}">Versión HN</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/4')}}">Jira SAP</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/5')}}">Versión SAP</a></li>
        </ol>
        @break

    @case(2)
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('admin/1')}}">Todo</a></li>
            <li class="breadcrumb-item">Jira HN</li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/3')}}">Versión HN</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/4')}}">Jira SAP</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/5')}}">Versión SAP</a></li>
        </ol>
        @break

        @case(3)
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('admin/1')}}">Todo</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/2')}}">Jira HN</a></li>
            <li class="breadcrumb-item">Versión HN</li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/4')}}">Jira SAP</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/5')}}">Versión SAP</a></li>
        </ol>
        @break
        @case(4)
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('admin/1')}}">Todo</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/2')}}">Jira HN</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/3')}}">Versión HN</a></li>
            <li class="breadcrumb-item">Jira SAP</li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/5')}}">Versión SAP</a></li>
        </ol>
        @break
        @case(5)
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ asset('admin/1')}}">Todo</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/2')}}">Jira HN</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/3')}}">Versión HN</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('admin/4')}}">Jira SAP</a></li>
            <li class="breadcrumb-item">Versión SAP</li>
        </ol>
        @break
@endswitch