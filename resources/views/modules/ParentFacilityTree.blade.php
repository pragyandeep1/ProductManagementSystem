<ul>
    @foreach ($children as $child)
        <li>
            {{ $child->name }}
            @if (count($child->childs))
                @include('modules.ParentFacilityTree', ['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>
