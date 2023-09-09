<script>
    @if (session()->has('feedbacks'))
       @foreach (session()->get('feedbacks') as $item)
            $.toast({
                    heading: "{{$item['title']}}",
                    text: "{{$item['body']}}",
                    showHideTransition: "slide",
                    icon: "{{$item['type']}}",
                });
       @endforeach
    @endif
</script>
