<template>
  <v-app>
    <Header />
    <v-content style="min-height: 660px;">
      <v-container>
        <nuxt />
      </v-container>
    </v-content>
    <Footer />
  </v-app>
</template>

<script>
import Header from "@/layouts/header.vue";
import Footer from "@/layouts/footer.vue";
import Control from "@/layouts/control.vue";

export default {
  components: {
    Header,
    Footer,
    Control
  }
};
</script>
