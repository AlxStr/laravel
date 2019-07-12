<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Parent</th>
        </tr>
    </thead>

    <tbody>
    @foreach ($regions as $region)
        <tr>
            <td>{{ $region->id }}</td>
            <td><a href="{{ route('admin.regions.show', $region) }}">{{ $region->name }}</a></td>
            <td>{{ $region->slug }}</td>
            <td>
                {{ $region->parent ? $region->parent->name : '' }}
            </td>
        </tr>
    @endforeach
    </tbody>

    <div class="d-flex justify-content-center">
        {{ $regions->links() }}
    </div>
</table>
