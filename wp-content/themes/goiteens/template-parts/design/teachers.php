{% set teachers = teachers %} {% set teachersItems = teachers.items %}
<section class="section teachers" id="teachers">
  <div class="container">
    <h2 class="section-title">{{teachers.title}}</h2>

    <p class="text-label teachers__description">{{teachers.description}}</p>

    <div class="teachers-slider-js teachers__list">
      {% for item in teachersItems %}
      <div class="teachers__item">
        <picture class="teachers__img-wrap">
          <source srcset="
              ./assets/images/teachers/teacher-{{item.id}}_lg.webp    1x,
              ./assets/images/teachers/teacher-{{item.id}}_lg@2x.webp 2x
            " media="(min-width: 768px)" type="image/webp" />

          <source srcset="
              ./assets/images/teachers/teacher-{{item.id}}_lg.jpg    1x,
              ./assets/images/teachers/teacher-{{item.id}}_lg@2x.jpg 2x
            " media="(min-width: 768px)" type="image/jpeg" />
          <source srcset="
              ./assets/images/teachers/teacher-{{item.id}}_sm.webp    1x,
              ./assets/images/teachers/teacher-{{item.id}}_sm@2x.webp 2x
            " media="(max-width: 767px)" type="image/webp" />

          <source srcset="./assets/images/teachers/teacher-{{item.id}}_sm@2x.jpg 2x" media="(max-width: 767px)"
            type="image/jpeg" />
          <img class="teachers__item-img" src="./assets/images/teachers/teacher-{{item.id}}_sm.jpg"
            alt="{{teachers.img_alt}} {{item.name}}" width="190" height="280" loading="lazy" />
        </picture>

        <p class="text-accent teachers__item-title">{{item.name}}</p>

        <p class="teachers__item-description">{{item.description}}</p>
        <p class="text-accent">{{item.position}}</p>
      </div>
      {% endfor %}
    </div>
  </div>
</section>