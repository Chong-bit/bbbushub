<x-app-layout>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Bus Form -->
    <div class="d-flex justify-content-center mt-4">
    <form method="POST" action="{{ route('admin.store') }}" class="form-inline">
        @csrf
        <div class="input-group" style="margin-bottom:3%; margin-top:3%; margin-left: 36%;">
            <span class="input-group-text">Plate:</span>
            <input 
                type="text" 
                name="plate" 
                class="form-control" 
                style="height: 3rem; border-radius: 5px 5px 5px 5px;" 
                placeholder="Enter plate" 
                required>
            <button 
                type="submit" 
                class="btn btn-primary" 
                style="height: 3rem; font-size: 1rem; font-weight: bold; margin: 0; padding: 0 1.5rem; background-color: dodgerblue; color: white; border-radius: 5px 5px 5px 5px;">
                Add
            </button>
        </div>
    </form>
</div>




    <!-- Bus List Table -->
     <style>
        table, th , td {
            border:1px solid black;
        }
        td {
            text-align: center;
        }
        th, td{
            padding:10px;
        }
     </style>
    <table class="table table-bordered border-primary mt-5 " style="width: 45%; margin: 0 auto;" >
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Plate</th>
            <th colspan="2" scope="col">Edit</th>
            <th colspan="2" scope="col">Delete</th>
        </tr>
    </thead>
    <tbody id="busListTable">
        @foreach ($buses as $bus)
            <tr data-id="{{ $bus->id }}">
                <th scope="row">{{ $loop->iteration }}</th>
                <td class="plate">{{ $bus->plate }}</td>
                <td colspan="2">
                    <div class="d-flex align-items-center gap-2">
                        <!-- Edit Button -->
                        <button 
                            type="button" 
                            class="btn editRowButton" 
                            style="height: 2.5rem; font-size: 1rem; font-weight: bold; margin: 0; padding: 0 1.5rem; background-color: dodgerblue; color: white; border-radius: 5px;">
                            Edit
                        </button>

                        <!-- Save Button (Hidden by default) -->
                        <button 
                            type="button" 
                            class="btn saveRowButton" 
                            style="display: none; height: 2.5rem; font-size: 1rem; font-weight: bold; margin: 0; padding: 0 1.5rem; background-color: green; color: white; border-radius: 5px;">
                            Save
                        </button>
                       <td>
                        <!-- Delete Button -->
                        <form method="POST" action="{{ route('admin.destroy', $bus->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit" 
                                class="btn deleteRowButton" 
                                style="height: 2.5rem; font-size: 1rem; font-weight: bold; margin: 0; padding: 0 1.5rem; background-color: red; color: white; border-radius: 5px;">
                                Delete
                            </button>
                        </form>
                    </div>
                    </td>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>





    <script>
        // Add event listener for edit buttons
        document.querySelectorAll('.editRowButton').forEach(button => {
            button.addEventListener('click', function () {
                const row = button.closest('tr');
                const plateCell = row.querySelector('.plate');
                const saveButton = row.querySelector('.saveRowButton');

                // Make the plate cell editable
                plateCell.contentEditable = true;
                plateCell.focus();

                // Show the save button and hide the edit button
                button.style.display = 'none';
                saveButton.style.display = 'inline-block';
            });
        });

        // Add event listener for save buttons
        document.querySelectorAll('.saveRowButton').forEach(button => {
            button.addEventListener('click', async function () {
                const row = button.closest('tr');
                const plateCell = row.querySelector('.plate');
                const editButton = row.querySelector('.editRowButton');
                const busId = row.getAttribute('data-id');
                const newPlate = plateCell.textContent.trim();

                try {
                const response = await fetch(`/admin/bus/${busId}`, {
                method: 'PUT',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ plate: newPlate }),
                });

                if (!response.ok) {
                const errorData = await response.json(); // Get detailed error response
                console.error('Error response:', errorData);
                throw new Error(errorData.message || 'Failed to update bus.');
                }

                const result = await response.json();
                if (result.success) {
                alert('Bus updated successfully!');
                } else {
                alert('Error updating bus: ' + result.message);
                }
                } catch (error) {
                console.error('AJAX Error:', error); // Log the actual error for debugging
                alert('An error occurred while updating the bus.');
                }


                // Disable editing and switch buttons back
                plateCell.contentEditable = false;
                button.style.display = 'none';
                editButton.style.display = 'inline-block';
            });
        });
    </script>
</x-app-layout>
