@extends('layouts.app')

@section('content')
    <div id="content">
        <h1 class="mb-3">Halaman Details</h1>

        <div class="row">
            <div class="col-8">
                <h3 class="mb-2">{{ $task->name }}</h3>
                <p class="text-muted">{{ $task->description }}</p>
            </div>
            <div class="col-4">
                <span class="badge text-bg-{{ $task->priorityClass }}
                badge-pill" style="width: fit-content">
                    {{ $task->priority}}
                </span>
                <span class="badge text-bg-{{ $task->status ? 'success' :
                'danger' }} badge pill"
                    style="width: fit-content">
                    {{ $task->status ? 'Selesai' : 'Belum selesai'}}
                </span>
            </div>  
        </div> 
    </div>              
@endsection