<tr class="treegrid-{{ $data->id_tree_comission }} {{ is_null($data->id_tree_comission_prev) ? 'treegrid-parent-0' : 'treegrid-parent-'.$data->id_tree_comission_prev }}">
    <td class="text-primary">#{{ $data->id_tree_comission }} - {{ $data->user->name }}</td>
    <td class="text-primary">{{ is_null($data->percent) ? '0,00' : number_format($data->percent, 2, ',','') }} %</td>
    <td>
        <div class="row d-flex justify-content-center">
            <form class="col-12 col-sm-6 col-md-6" method="POST" action="{{ route('admin.tree.remove') }}">
                @csrf
                <input type="hidden" name="idTreeNode" value="{{ $data->id_tree_comission }}">
                <button type="submit" class="btn btn-block btn-outline-primary btn-sm">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>

@foreach ($data->child as $item)

    {{ render_tree($item) }}
@endforeach