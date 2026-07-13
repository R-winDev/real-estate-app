@if($errors->any())
    <div>
        @foreach($errors->all() as $error)
            <x-alert type="danger">{{ $error }}</x-alert>
        @endforeach
    </div>
@endif
