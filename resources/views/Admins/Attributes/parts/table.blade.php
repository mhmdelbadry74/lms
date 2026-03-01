<table class="table table-hover table-responive">
    <thead>
        <td>
            {{ __("#") }}
        </td>
        <td>
            {{ __("Arabic Name") }}
        </td>
        <td>
            {{ __("English Name") }}
        </td>
        <td>
            {{ __("Field Type") }}
        </td>
        <td>
            {{ __("Actions") }}
        </td>
    </thead>
    <tbody>
        @foreach ($attributes as $key => $attribute)
            <tr>
                <td>
                    {{ $key + 1 }}
                </td>
                <td>
                    {{ $attribute->name_ar }}
                </td>
                <td>
                    {{ $attribute->name_en }}
                </td>
                <td>
                    {{ __($attribute->attribute_type) }}
                </td>
                <td class="row">
                    <div class="col-3">
                    @if(auth("web")->user()->hasRole("super_admin"))
                        @include("Admins.attributes.parts.update")
                    @endif
                    </div>
                    @if(auth("web")->user()->hasRole("super_admin"))   
                        <form class="col-3"action="{{ route('admin.varaity.destroy',$attribute->id) }}"method="delete">
                            <button class="btn btn-danger">
                                <span class="fa fa-trash"></span>
                            </button>
                        </form>
                    @endif           
                </td>
            </tr>
        @endforeach
    </tbody>
</table>