<div>
    @if ($parent)
    
    <div class="container card card-body my-4">
        <!-- Parent Card -->
            <div class="card-header bg-primary text-white">
                <h5>Parent</h5>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Full Name: </strong>{{$parent->fullname->last_name .' '.$parent->fullname->first_name.' '.$parent->fullname->middle_name}}</div>
                    <div class="col-md-4"><strong>Email: </strong>{{$parent->email}}</div>
                    <div class="col-md-4"><strong>Phone: </strong>{{$parent->telephone}}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><strong>National ID: </strong>{{$parent->national_id}}</div>
                    <div class="col-md-4"><strong>Employer: </strong>{{$parent->employer}}</div>
                    <div class="col-md-4"><strong>Insurance: </strong>{{$parent->insurance}}</div>
                </div>
                <div class="row mb-2 d-flex justify-content-between">
                    <div class="col-md-4"><strong>Relationship: </strong>
                        @foreach ($relationships as $item)
                            {{$item->id === $parent->relationship_id ? $item->relationship : ''}}
                        @endforeach
                        
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editParentModal">Edit</button>
                        @livewire('edit-parent-modal',['parent'=>$parent], key($parent->id))
                    </div>
                </div>
            </div>
        

        <!-- Children Card -->
        <div class="card shadow-sm mt-3">
            <div class="card-header bg-secondary text-white">
                <h5>Children Details</h5>
            </div>
            <div class="card-body">
                <!-- List of Children -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        @if (!$children)

                        <div class="card mb-2">                         
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <p>No children related to this Parent</p>
                                </div>
                            </div>
                        </div>

                        @else
                            
                        @foreach ($children as $item)
                        
                        <div class="card mb-2">                         
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4"><strong>Child Name:</strong> {{$item->fullname->last_name.' '.$item->fullname->first_name.' '.$item->fullname->middle_name}}</div>
                                    <div class="col-md-4"><strong>Date of Birth:</strong> {{$item->dob}}</div>
                                    <div class="col-md-4 text-end">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editChildModal-{{$item->id}}">Edit</button>
                                        @livewire('edit-child-modal',['child'=>$item], key($item->id))
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addChildModal">Add Child</button>
                        @livewire('add-child-modal',['parent'=>$parent])
                    </div>
                </div>
            </div>
        </div>
    </div>
    


    @else
        
    {{-- content when parent is empty --}}

    @endif

</div>
</div>
