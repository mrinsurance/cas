@extends('mylayout.master')

@section('title', 'Agent Account Assignment')

@section('body')
<aside class="right-side strech">
    <section class="content-header">
        <h1>Assign Accounts to Agents</h1>
        <ol class="breadcrumb">
            <li><a href="{{HOME_LINK}}"><i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Dashboard</a></li>
            <li class="active">Agent Assignment</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="users" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i> Assign Accounts
                        </h3>
                    </div>
                    <div class="panel-body">
                        <!-- Form -->
                        <form id="assignment-form" class="form-horizontal">
                            <div class="form-group">
                                <label for="agent" class="col-md-3 control-label">Agent Name</label>
                                <div class="col-md-6">
                                    <select name="agent_id" id="agent" class="form-control">
                                        <option value="">--- Select Agent ---</option>
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="accounts" class="col-md-3 control-label">Accounts</label>
                                <div class="col-md-6">
                                    <!-- Searchable Dropdown -->
                                    <div class="searchable-dropdown">
                                        <input type="text" id="account-search" class="form-control" placeholder="Search accounts..." />
                                        <select name="accounts[]" id="accounts" class="form-control" size="5">
                                            <!-- Options will be dynamically added via AJAX -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-6 text-center">
                                    <button type="button" id="add-button" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </form>

                        <!-- Assignment Table -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Agent Assignments</label>
                            <div class="col-md-9">
                                <table class="table table-bordered" id="agent-account-table">
                                    <thead>
                                        <tr>
                                            <th>Account No.</th>
                                            <th>A/c Holder Name</th>
                                            <th>Father Name</th>
                                            <th>PIN Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Rows will be dynamically added -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
@endsection

@push('extra_js')
<script>
    $(document).ready(function () {
        const accountsDropdown = $('#accounts');
        const accountSearchInput = $('#account-search');
        const agentAccountTable = $('#agent-account-table tbody');

        // Fetch accounts dynamically and populate dropdown
        function fetchAccounts(agentId = null, query = '') {
            $.ajax({
                url: "{{ route('fetch.accounts') }}",
                method: "GET",
                data: { agent_id: agentId, term: query },
                success: function (response) {
                    accountsDropdown.empty();
                    response.data.forEach(account => {
                        accountsDropdown.append(
                            `<option value="${account.id}">${account.account_no}</option>`
                        );
                    });
                },
                error: function () {
                    alert('Failed to load accounts. Please try again.');
                }
            });
        }

        // Fetch assigned accounts and populate the table
    function fetchAssignedAccounts(agentId) {
        $.ajax({
            url: "{{ route('fetch.assigned.accounts') }}",
            method: "GET",
            data: { agent_id: agentId },
            success: function (response) {
                agentAccountTable.empty();
                response.data.forEach(account => {
                    const row = `
                        <tr>
                            <td>${account.account_no}</td>
                            <td>${account.full_name}</td>
                            <td>${account.father_name}</td>
                            <td>${account.pin_code}</td>
                        </tr>
                    `;
                    agentAccountTable.append(row);
                });
            },
            error: function () {
                alert('Failed to load assigned accounts. Please try again.');
            }
        });
    }

        // Load all accounts on page load
    fetchAccounts();

        // Fetch accounts when an agent is selected
        $('#agent').on('change', function () {
            const agentId = $(this).val();
            if (agentId) {
            fetchAccounts(agentId); // Load accounts for the selected agent
            fetchAssignedAccounts(agentId); // Load assigned accounts for the selected agent
            } else {
                fetchAccounts(); // Load all accounts if no agent is selected
                agentAccountTable.empty(); // Clear the table
            }
        });

        // Trigger search when typing in the search box
        accountSearchInput.on('input', function () {
            const query = $(this).val();
            const agentId = $('#agent').val();
            fetchAccounts(agentId, query);
        });

        // Add selected agent and accounts to the table
        $('#add-button').on('click', function () {
            const agentId = $('#agent').val();
            const accountId = $('#accounts').val();
            const selectedAccountOption = $('#accounts option:selected');

            if (!agentId) {
                alert('Please select an agent.');
                return;
            }

            if (!accountId) {
                alert('Please select an account.');
                return;
            }

            $.ajax({
                url: "{{ route('save.assignments') }}",
                method: "POST",
                data: {
                    agent_id: agentId,
                    account_id: accountId,
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);

                        // Add a new row to the table
                        const agentName = $('#agent option:selected').text();
                        const accountText = selectedAccountOption.text();

                        const row = `
                            <tr>
                                <td>${agentName}</td>
                                <td>${accountText}</td>
                            </tr>
                        `;
                        $('#agent-account-table tbody').append(row);
                        selectedAccountOption.remove();
                        // Clear selections
                        $('#agent').val('');
                        $('#accounts').val('');
                    }
                },
                error: function () {
                    alert('Failed to save assignment. Please try again.');
                },
            });
        });



        // Load initial accounts
        fetchAccounts();
    });
</script>
@endpush
