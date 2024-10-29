{{-- <ul>
    @foreach ($subcategories as $subcategory)
        <li>{{ $subcategory->name }}</li>
        @if (count($subcategory->subcategory))
            @include('modules.ParentPositionTree', ['subcategories' => $subcategory->subcategory])
        @endif
    @endforeach
</ul> --}}
<ul>
    @foreach ($childs as $child)
        <li>
            {{ $child->name }}
            @if (count($child->childs))
                @include('modules.ParentPositionTree', ['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>
