@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-4">
                <div class="d-flex justify-content-between">
                    <h1 class="text-center my-3">Agencies</h1>
                    <div class="d-flex"><button class="btn btn-success align-self-center addBtn" addType="agn">Add</button></div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body bg-white">
                        <table class="table table-hover display nowrap w-100" id="agnTable">
                            <thead>
                                <tr class="table-dark">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agns as $index => $agn)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <td>{{ $agn->name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning editBtn" editType="agn" value="{{ $agn->name }}" editId="{{ $agn->id }}"><i class="bi bi-gear"></i></button>
                                            <button class="btn btn-sm btn-danger delBtn" delType="agn" delId="{{ $agn->id }}"><i class="bi bi-trash3"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-4">
                <div class="d-flex justify-content-between">
                    <h1 class="text-center my-3">Branches</h1>
                    <div class="d-flex"><button class="btn btn-success align-self-center addBtn" addType="brn">Add</button></div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body bg-white">
                        <table class="table table-hover display" id="brnTable">
                            <thead>
                                <tr class="table-dark">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Agency</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brns as $index => $brn)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <td>{{ $brn->name }}</td>
                                        <td>{{ optional($brn->getAgn)->name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning editBtn" editType="brn" value="{{ $brn->name }}" aid="{{ $brn->agn }}" editId="{{ $brn->id }}"><i class="bi bi-gear"></i></button>
                                            <button class="btn btn-sm btn-danger delBtn" delType="brn" delId="{{ $brn->id }}"><i class="bi bi-trash3"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-4">
                <div class="d-flex justify-content-between">
                    <h1 class="text-center my-3">Departments</h1>
                    <div class="d-flex"><button class="btn btn-success align-self-center addBtn" addType="dpm">Add</button></div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body bg-white">
                        <table class="table table-hover display" id="dpmTable">
                            <thead>
                                <tr class="table-dark">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Agency</th>
                                    <th>Prefix</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dpms as $index => $dpm)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <td>{{ $dpm->name }}</td>
                                        <td>{{ optional($dpm->getBrn)->name }}</td>
                                        <td>{{ optional(optional($dpm->getBrn)->getAgn)->name }}</td>
                                        <td>{{ $dpm->prefix }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning editBtn" editType="dpm" value="{{ $dpm->name }}" prefix="{{ $dpm->prefix }}" brn="{{ $dpm->brn }}" editId="{{ $dpm->id }}"><i class="bi bi-gear"></i></button>
                                            <button class="btn btn-sm btn-danger delBtn" delType="dpm" delId="{{ $dpm->id }}"><i class="bi bi-trash3"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-4">
                <div class="d-flex justify-content-between">
                    <h1 class="text-center my-3">Permissions</h1>
                    <div class="d-flex"><button class="btn btn-success align-self-center addBtn" addType="perm">Add</button></div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body bg-white">
                        <table class="table table-hover display" id="permTable">
                            <thead>
                                <tr class="table-dark">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Users</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perms as $index => $perm)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <td>{{ $perm->name }}</td>
                                        <td>{{ App\Models\User::with('roles')->get()->filter(fn ($user) => $user->roles->where('name', 'Super Admin')->toArray())->count() }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger delBtn" delType="perm" delId="{{ $perm->name }}"><i class="bi bi-trash3"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-4">
                <div class="d-flex justify-content-between">
                    <h1 class="text-center my-3">Role</h1>
                    <div class="d-flex"><button class="btn btn-success align-self-center addBtn" addType="role">Add</button></div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body bg-white">
                        <table class="table table-hover display" id="roleTable">
                            <thead>
                                <tr class="table-dark">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Users</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $index => $role)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ App\Models\User::with('roles')->get()->filter(fn ($user) => $user->roles->where('name', $role->name)->toArray())->count() }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger delBtn" delType="role" delId="{{ $role->name }}"><i class="bi bi-trash3"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $(".addBtn").click(function() {
                const atype = $(this).attr("addType");
                if (atype === 'agn') {
                    Swal.fire({
                        title: 'Agency',
                        input: "text",
                        inputLabel: "Enter agency name",
                        showCancelButton: true,
                        preConfirm: (agnName) => {
                            if (agnName) {
                                $.ajax({
                                    url: "/data/add",
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: { addType:atype ,agnname:agnName},
                                    success: function (response) {
                                        // console.log(response);
                                        Swal.fire({
                                            title: "Success",
                                            // text: "That thing is still around?",
                                            icon: "success"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    },
                                    error: (error) => {
                                        // console.log(error);
                                        Swal.fire({
                                            title: "Sorry!",
                                            text: "Something wrong!",
                                            icon: "error"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.showValidationMessage(`Please enter agency name.`);
                            }
                        },
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading()
                    });
                } else if (atype === 'brn') {
                    Swal.fire({
                        title: 'Branch',
                        html: `
                            <div class="mb-3">
                                <input type="text" maxlength="100" class="form-control" maxlength="100" id="bname" placeholder="Branch name">
                            </div>
                            <select class="form-select" aria-label="Default select example" id="agn">
                                <option value="" selected disabled>Select agency</option>
                                @foreach ($agns as $agn)
                                    <option value="{{ $agn->id }}">{{ $agn->name }}</option>
                                @endforeach
                            </select>
                        `,
                        showCancelButton: true,
                        preConfirm: () => {
                            const bname = document.getElementById("bname").value;
                            const bagn = document.getElementById("agn").value;
                            if (bname && bagn) {
                                $.ajax({
                                    url: "/data/add",
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: { addType:atype, bName:bname, bAgn: bagn},
                                    success: function (response) {
                                        // console.log(response);
                                        Swal.fire({
                                            title: "Success",
                                            // text: "That thing is still around?",
                                            icon: "success"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    },
                                    error: (error) => {
                                        // console.log(error);
                                        Swal.fire({
                                            title: "Sorry!",
                                            text: "Something wrong!",
                                            icon: "error"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.showValidationMessage(`Please enter name and select agency.`);
                            }
                        },
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading()
                    });
                } else if (atype === 'dpm') {
                    Swal.fire({
                        title: 'Department',
                        html: `
                            <div class="mb-3">
                                <input type="text" maxlength="100" class="form-control" id="dname" placeholder="Department name">
                            </div>
                            <div class="mb-3">
                                <input type="text" maxlength="100" class="form-control" id="prefix" placeholder="Prefix">
                            </div>
                            <select class="form-select" aria-label="Default select example" id="dbrn">
                                <option value="" selected disabled>Select branch</option>
                                @foreach ($brns as $brn)
                                    <option value="{{ $brn->id }}">{{ $brn->name }}</option>
                                @endforeach
                            </select>
                        `,
                        showCancelButton: true,
                        preConfirm: () => {
                            const dpmname = document.getElementById("dname").value;
                            const prefix = document.getElementById("prefix").value;
                            const dbrn = document.getElementById("dbrn").value;
                            if (dpmname && dbrn) {
                                $.ajax({
                                    url: "/data/add",
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: { addType:atype, dName:dpmname, dBrn: dbrn, prefix:prefix},
                                    success: function (response) {
                                        // console.log(response);
                                        Swal.fire({
                                            title: "Success",
                                            // text: "That thing is still around?",
                                            icon: "success"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    },
                                    error: (error) => {
                                        // console.log(error);
                                        Swal.fire({
                                            title: "Sorry!",
                                            text: "Something wrong!",
                                            icon: "error"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.showValidationMessage(`Please enter name and select branch.`);
                            }
                        },
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading()
                    });
                } else if (atype === 'perm') {
                    Swal.fire({
                        title: 'Permission',
                        input: "text",
                        inputLabel: "Enter permission name",
                        showCancelButton: true,
                        preConfirm: (permName) => {
                            if (permName) {
                                $.ajax({
                                    url: "/data/add",
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: { addType:atype ,permName:permName},
                                    success: function (response) {
                                        // console.log(response);
                                        Swal.fire({
                                            title: "Success",
                                            // text: "That thing is still around?",
                                            icon: "success"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    },
                                    error: (error) => {
                                        // console.log(error);
                                        Swal.fire({
                                            title: "Sorry!",
                                            text: "Something wrong!",
                                            icon: "error"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.showValidationMessage(`Please enter permission name.`);
                            }
                        },
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading()
                    });
                } else if (atype === 'role') {
                    Swal.fire({
                        title: 'Role',
                        input: "text",
                        inputLabel: "Enter role name",
                        showCancelButton: true,
                        preConfirm: (roleName) => {
                            if (roleName) {
                                $.ajax({
                                    url: "/data/add",
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: { addType:atype ,roleName:roleName},
                                    success: function (response) {
                                        // console.log(response);
                                        Swal.fire({
                                            title: "Success",
                                            // text: "That thing is still around?",
                                            icon: "success"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    },
                                    error: (error) => {
                                        // console.log(error);
                                        Swal.fire({
                                            title: "Sorry!",
                                            text: "Something wrong!",
                                            icon: "error"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.showValidationMessage(`Please enter permission name.`);
                            }
                        },
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading()
                    });
                }
            });

            $(".editBtn").click(function() {
                const edittype = $(this).attr("editType");
                const editId = $(this).attr("editId");
                const name = $(this).val();
                if (edittype === 'agn') {
                    Swal.fire({
                        title: 'Agency',
                        input: "text",
                        inputValue: name,
                        inputLabel: "Enter agency name",
                        showCancelButton: true,
                        preConfirm: (agnName) => {
                            if (agnName) {
                                $.ajax({
                                    url: "/data/update",
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: { addType:edittype ,agnname:agnName, eid:editId},
                                    success: function (response) {
                                        // console.log(response);
                                        Swal.fire({
                                            title: "Success",
                                            // text: "That thing is still around?",
                                            icon: "success"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    },
                                    error: (error) => {
                                        // console.log(error);
                                        Swal.fire({
                                            title: "Sorry!",
                                            text: "Something wrong!",
                                            icon: "error"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.showValidationMessage(`Please enter agency name.`);
                            }
                        },
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading()
                    });
                } else if (edittype === 'brn') {
                    const agnid = $(this).attr("aid");
                    Swal.fire({
                        title: 'Branch',
                        html: `
                            <div class="mb-3">
                                <input type="text" class="form-control" maxlength="100" id="bname" value="${name}" placeholder="Branch name">
                            </div>
                            <select class="form-select" aria-label="Default select example" id="agn">
                                <option value="" selected disabled>Select agency</option>
                                @foreach ($agns as $agn)
                                    <option value="{{ $agn->id }}" ${agnid == "{{ $agn->id }}" ? 'selected' : ''}>{{ $agn->name }}</option>
                                @endforeach
                            </select>
                        `,
                        showCancelButton: true,
                        preConfirm: () => {
                            const bname = document.getElementById("bname").value;
                            const bagn = document.getElementById("agn").value;
                            if (bname && bagn) {
                                $.ajax({
                                    url: "/data/update",
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: { addType:edittype, bName:bname, bAgn: bagn, eid:editId},
                                    success: function (response) {
                                        // console.log(response);
                                        Swal.fire({
                                            title: "Success",
                                            // text: "That thing is still around?",
                                            icon: "success"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    },
                                    error: (error) => {
                                        // console.log(error);
                                        Swal.fire({
                                            title: "Sorry!",
                                            text: "Something wrong!",
                                            icon: "error"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.showValidationMessage(`Please enter name and select agency.`);
                            }
                        },
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading()
                    });
                } else if (edittype === 'dpm') {
                    const prefixx = $(this).attr("prefix");
                    const brnn = $(this).attr("brn");

                    Swal.fire({
                        title: 'Department',
                        html: `
                            <div class="mb-3">
                                <input type="text" maxlength="100" class="form-control" id="dname" value="${name}" placeholder="Department name">
                            </div>
                            <div class="mb-3">
                                <input type="text" maxlength="100" class="form-control" id="prefix" value="${prefixx}" placeholder="Prefix">
                            </div>
                            <select class="form-select" aria-label="Default select example" id="dbrn">
                                <option value="" selected disabled>Select branch</option>
                                @foreach ($brns as $brn)
                                    <option value="{{ $brn->id }}" ${brnn == "{{ $brn->id }}" ? 'selected' : ''}>{{ $brn->name }}</option>
                                @endforeach
                            </select>
                        `,
                        showCancelButton: true,
                        preConfirm: () => {
                            const dpmname = document.getElementById("dname").value;
                            const prefix = document.getElementById("prefix").value;
                            const dbrn = document.getElementById("dbrn").value;
                            if (dpmname && dbrn) {
                                $.ajax({
                                    url: "/data/update",
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: { addType:edittype, dName:dpmname, dBrn: dbrn, prefix:prefix , eid:editId},
                                    success: function (response) {
                                        // console.log(response);
                                        Swal.fire({
                                            title: "Success",
                                            // text: "That thing is still around?",
                                            icon: "success"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    },
                                    error: (error) => {
                                        // console.log(error);
                                        Swal.fire({
                                            title: "Sorry!",
                                            text: "Something wrong!",
                                            icon: "error"
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.showValidationMessage(`Please enter name and select branch.`);
                            }
                        },
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading()
                    });
                }
            });

            $(".delBtn").click(function() {
                const delType = $(this).attr("delType");
                const delId = $(this).attr("delId");
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                    preConfirm: (agnName) => {
                        if (agnName) {
                            $.ajax({
                                url: "/data/delete",
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: { deltype:delType ,delid:delId},
                                success: function (response) {
                                    // console.log(response);
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success"
                                    }).then((res) => {
                                        if (res.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                },
                                error: (error) => {
                                    console.log(error);
                                    Swal.fire({
                                        title: "Sorry!",
                                        text: "Something wrong!",
                                        icon: "error"
                                    }).then((res) => {
                                        if (res.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                }
                            });
                        } else {
                            Swal.showValidationMessage(`Please enter agency name.`);
                        }
                    },
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading()
                });
            });
        });
    </script>
@endsection
