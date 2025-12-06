import "./libs/trix";
import "./bootstrap";
import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";

// Swiper JS
import Swiper from "swiper";
import { Autoplay, EffectFade, Pagination, Navigation } from "swiper/modules";
import "swiper/css";
import "swiper/css/effect-fade";
import "swiper/css/pagination";
import "swiper/css/navigation";

Alpine.plugin(collapse);
window.Alpine = Alpine;
window.Swiper = Swiper;
window.SwiperModules = { Autoplay, EffectFade, Pagination, Navigation };
Alpine.start();
