<tr>
    <td>{{ $setting->label }}</td>
    <td align="right">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default" title="Edit" data-url="{{ route('admin.ecommerce.report.edit', $setting->key) }}">
                <span class="glyphicon glyphicon-pencil"></span>
            </button>
        </div>
    </td>
</tr>