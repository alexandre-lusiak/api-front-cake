#[Route('/blog/{slug}', name: 'blog_show')]
public function show(string $slug): Response
{
// $slug will equal the dynamic part of the URL
// e.g. at /blog/yay-routing, then $slug='yay-routing'

// ...
}
}