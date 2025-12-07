<script setup>
// Dữ liệu tĩnh cho UI - Dễ dàng config
const footerLinks = {
  shop: [
    { name: "SUNGLASSES", url: "#" },
    { name: "OPTICAL", url: "#" },
    { name: "COLLABORATIONS", url: "#" },
    { name: "ARCHIVE", url: "#" },
  ],
  support: [
    { name: "SHIPPING & RETURNS", url: "#" },
    { name: "SIZE GUIDE", url: "#" },
    { name: "CARE INSTRUCTIONS", url: "#" },
    { name: "FAQ", url: "#" },
  ],
  legal: [
    { name: "TERMS OF SERVICE", url: "#" },
    { name: "PRIVACY POLICY", url: "#" },
    { name: "ACCESSIBILITY", url: "#" },
  ],
};

const currentYear = new Date().getFullYear();
</script>

<template>
  <footer
    class="bg-black text-white w-full border-t border-white/20 font-mono overflow-hidden"
  >
    <div
      class="border-b border-white/20 py-3 overflow-hidden relative flex whitespace-nowrap"
    >
      <div
        class="animate-marquee flex gap-8 text-xs font-bold tracking-[0.2em]"
      >
        <span v-for="i in 10" :key="i"
          >VISIONARY — SEE THE UNSEEN — FUTURE OPTICS —
        </span>
      </div>
      <div
        class="animate-marquee2 absolute top-3 flex gap-8 text-xs font-bold tracking-[0.2em]"
      >
        <span v-for="i in 10" :key="i"
          >VISIONARY — SEE THE UNSEEN — FUTURE OPTICS —
        </span>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 h-auto md:h-[400px]">
      <div
        class="md:col-span-5 p-8 flex flex-col justify-between border-b md:border-b-0 border-white/20 md:border-r"
      >
        <div>
          <h2
            class="text-6xl md:text-8xl font-black tracking-tighter leading-none mb-4 -ml-1"
          >
            VISION
            <br />
            ARY.
          </h2>
        </div>

        <div class="mt-12 md:mt-0 group">
          <label
            class="text-[10px] uppercase tracking-widest text-neutral-500 mb-2 block"
            >Newsletter</label
          >
          <div class="flex items-center border-b border-white pb-2 relative">
            <input
              type="text"
              placeholder="ENTER EMAIL"
              class="bg-transparent w-full outline-none text-sm placeholder-neutral-600 uppercase"
            />
            <button
              class="text-xs font-bold hover:text-neutral-400 transition-colors"
            >
              JOIN
            </button>

            <div
              class="absolute -bottom-px left-0 w-0 h-px bg-white transition-all duration-300 group-hover:w-full"
            ></div>
          </div>
        </div>
      </div>

      <div
        class="md:col-span-4 grid grid-cols-2 border-b md:border-b-0 border-white/20 md:border-r"
      >
        <div class="p-8 border-r border-white/20 flex flex-col gap-6">
          <h3
            class="text-[10px] font-bold text-neutral-500 uppercase tracking-widest"
          >
            Store
          </h3>
          <ul class="flex flex-col gap-3">
            <li v-for="link in footerLinks.shop" :key="link.name">
              <a
                :href="link.url"
                class="text-xs hover:pl-2 transition-all duration-300 hover:text-neutral-300 block"
              >
                {{ link.name }}
              </a>
            </li>
          </ul>
        </div>
        <div class="p-8 flex flex-col gap-6">
          <h3
            class="text-[10px] font-bold text-neutral-500 uppercase tracking-widest"
          >
            Support
          </h3>
          <ul class="flex flex-col gap-3">
            <li v-for="link in footerLinks.support" :key="link.name">
              <a
                :href="link.url"
                class="text-xs hover:pl-2 transition-all duration-300 hover:text-neutral-300 block"
              >
                {{ link.name }}
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="md:col-span-3 flex flex-col">
        <div class="flex-1 p-8 border-b border-white/20">
          <h3
            class="text-[10px] font-bold text-neutral-500 uppercase tracking-widest mb-6"
          >
            Connect
          </h3>
          <div class="flex flex-col gap-4">
            <a
              href="#"
              class="group flex items-center justify-between text-xs border border-white/20 p-3 hover:bg-white hover:text-black transition-colors duration-300"
            >
              <span>INSTAGRAM</span>
              <span
                class="group-hover:rotate-45 transition-transform duration-300"
                >↗</span
              >
            </a>
            <a
              href="#"
              class="group flex items-center justify-between text-xs border border-white/20 p-3 hover:bg-white hover:text-black transition-colors duration-300"
            >
              <span>TIKTOK</span>
              <span
                class="group-hover:rotate-45 transition-transform duration-300"
                >↗</span
              >
            </a>
          </div>
        </div>

        <div class="p-8 h-full flex flex-col justify-end">
          <div class="text-[10px] text-neutral-500 space-y-1">
            <p>HQ: 10.7626° N, 106.6602° E</p>
            <p>SAIGON, VIETNAM</p>
          </div>
        </div>
      </div>
    </div>

    <div
      class="border-t border-white/20 px-4 py-3 flex flex-col md:flex-row justify-between items-center text-[10px] uppercase text-neutral-500 tracking-wider"
    >
      <div class="flex gap-4">
        <span>&copy; {{ currentYear }} Visionary Inc.</span>
        <span class="hidden md:inline">|</span>
        <a href="#" class="hover:text-white transition-colors">Privacy</a>
        <a href="#" class="hover:text-white transition-colors">Terms</a>
      </div>
      <div class="mt-2 md:mt-0 flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
        <span>All Systems Operational</span>
      </div>
    </div>
  </footer>
</template>

<style scoped>
/* Custom CSS cho Marquee animation vì Tailwind không có sẵn keyframes phức tạp này mặc định */
.animate-marquee {
  animation: marquee 25s linear infinite;
}
.animate-marquee2 {
  animation: marquee2 25s linear infinite;
}

@keyframes marquee {
  0% {
    transform: translateX(0%);
  }
  100% {
    transform: translateX(-100%);
  }
}
@keyframes marquee2 {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(0%);
  }
}
</style>
