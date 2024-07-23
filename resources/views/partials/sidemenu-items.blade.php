
@foreach($items as $item)

<li @if($item->isActive) class="active" @endif>
    <a href="{!! $item->url() !!}">
        @if ( array_key_exists( 'icon', $item->attributes) )
            <i class="fa fa-{!! $item->attributes['icon'] !!}"></i>
        @else
            <i class=""></i>
        @endif
        <span class="nav-label">{!! $item->title !!}</span>
        @if($item->hasChildren())
            <span class="fa arrow"></span>
        @endif
    </a>
    
    @if($item->hasChildren())
    <ul class="nav nav-second-level">
        @include('partials.sidemenu-items', ['items' => $item->children()])
    </ul>
    @endif
</li>
@endforeach
