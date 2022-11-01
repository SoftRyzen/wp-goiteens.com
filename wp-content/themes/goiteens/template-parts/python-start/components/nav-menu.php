{% set items = menu %}

<nav class="nav">
  <ul class="list nav-list">
    {% for item in items %}
    <li class="nav-item">
      <a class="link nav-link" href="{{ item.link }}">{{ item.title }}</a>
    </li>
    {% endfor %}
  </ul>
</nav>
