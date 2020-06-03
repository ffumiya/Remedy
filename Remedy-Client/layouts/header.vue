<template>
  <div>
    <!-- Beginning of sidebar -->
    <v-navigation-drawer
      v-model="drawer"
      :mini-variant="miniVariant"
      :clipped="clipped"
      right
      fixed
      app
    >
      <v-list>
        <v-list-item @click.stop="drawer = !drawer">
          <v-list-item-action>
            <v-icon>mdi-close</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>close</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item v-for="(item, i) in items" :key="i" :to="item.to" router exact>
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <!-- End of sidebar -->

    <!-- Beginning of navbar -->
    <v-app-bar :clipped-left="clipped" fixed app class="primary">
      <v-toolbar-title v-text="title" class="white--text" />
      <v-spacer />
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" class="white--text" />
      <!-- <v-btn icon @click.stop="miniVariant = !miniVariant">
        <v-icon class="white--text">mdi-{{ `chevron-${miniVariant ? 'right' : 'left'}` }}</v-icon>
      </v-btn>
      <v-btn icon @click.stop="clipped = !clipped">
        <v-icon class="white--text">mdi-application</v-icon>
      </v-btn>
      <v-btn icon @click.stop="fixed = !fixed">
        <v-icon class="white--text">mdi-minus</v-icon>
      </v-btn>
      <v-btn icon @click.stop="rightDrawer = !rightDrawer">
        <v-icon class="white--text">mdi-menu</v-icon>
      </v-btn>-->
    </v-app-bar>
    <!-- End of navbar -->

    <!-- <v-navigation-drawer v-model="rightDrawer" :right="right" temporary fixed>
      <v-list>
        <v-list-item @click.native="right = !right">
          <v-list-item-action>
            <v-icon light>mdi-repeat</v-icon>
          </v-list-item-action>
          <v-list-item-title>Switch drawer (click me)</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>-->
  </div>
</template>

<script>
export default {
  data() {
    return {
      clipped: false,
      drawer: false,
      fixed: false,
      items: [
        {
          icon: "mdi-apps",
          title: "Welcome",
          to: "/"
        },
        {
          icon: "mdi-chart-bubble",
          title: "Video",
          to: "/video"
        }
      ],
      miniVariant: false,
      right: true,
      rightDrawer: false,
      title: "Remedy"
    };
  }
};
</script>