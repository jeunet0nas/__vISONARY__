<template>
  <div class="product-gallery">
    <Carousel
      id="gallery"
      :items-to-show="1"
      :wrap-around="false"
      v-model="currentSlide"
      ref="mainCarousel"
      class="border border-black"
    >
      <Slide v-for="(image, index) in images" :key="image.id || index">
        <div class="carousel__item">
          <img
            :src="image.url"
            :alt="image.alt || 'Product image'"
            class="w-full h-full object-cover aspect-square"
          />
        </div>
      </Slide>

      <template #addons>
        <Navigation />
      </template>
    </Carousel>

    <Carousel
      id="thumbnails"
      :items-to-show="4"
      :wrap-around="false"
      v-model="currentSlide"
      ref="thumbnailCarousel"
      class="mt-4"
    >
      <Slide v-for="(image, index) in images" :key="image.id || index">
        <div
          class="carousel__item thumbnail-item border border-black cursor-pointer"
          :class="{
            'border-black-800 ring-2 ring-black-500': index === currentSlide,
          }"
          @click="slideTo(index)"
        >
          <img
            :src="image.url"
            :alt="image.alt || `Thumbnail ${index + 1}`"
            class="w-full h-full object-cover aspect-square"
          />
        </div>
      </Slide>
    </Carousel>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Navigation } from "vue3-carousel";

const { images } = defineProps(["images"]);

// `currentSlide` sẽ đồng bộ cả 2 carousel
const currentSlide = ref(0);

// Refs để truy cập instance của carousel
const mainCarousel = ref(null);
const thumbnailCarousel = ref(null);

// Hàm để slide đến một index cụ thể
const slideTo = (val) => {
  currentSlide.value = val;
};

// Watch `currentSlide` để đồng bộ carousel chính với thumbnail
// (Đảm bảo khi main carousel tự động trượt, thumbnail cũng cập nhật)
watch(currentSlide, (newVal) => {
  if (
    thumbnailCarousel.value &&
    typeof thumbnailCarousel.value.slideTo === "function"
  ) {
    thumbnailCarousel.value.slideTo(newVal);
  }
});
</script>

<style scoped>
.thumbnail-item {
  transition: all 0.2s ease-in-out;
}

.thumbnail-item.ring-2 {
  border: 3px solid black;
}
</style>
