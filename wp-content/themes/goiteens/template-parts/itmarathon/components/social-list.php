{% set socialList = social_list %}
<ul class="list social__list">
  {% for item in socialList %}
  <li class="social__item">
    <a
      class="social__link"
      href="{{item.link}}"
      aria-label="{{item.id}}"
      target="_blank"
      rel="noopener noreferrer nofollow"
    >
      <svg class="social__svg" width="{{item.svg_width}}" height="{{item.svg_height}}">
        <use href="./assets/images/sprite.svg{{item.svg_id}}"></use>
      </svg>
    </a>
  </li>
  {% endfor %}
</ul>
