<template>
  <v-app>
    <v-navigation-drawer
      app
      left
      v-model="drawer"
    >
      <navbar />
    </v-navigation-drawer>
    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-spacer></v-spacer>
      <locale-dropdown />
      <user-dropdown />
    </v-app-bar>
    <v-main>
      <v-container fluid>
        <router-view>
          <loading ref="loading" />
          <transition name="page" mode="out-in">
            <component :is="layout" v-if="layout" />
          </transition>
        </router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import Loading from './Loading'
import Navbar from '~/components/Navbar'
import LocaleDropdown from './LocaleDropdown'
import UserDropdown from './UserDropdown'

// Load layout components dynamically.
const requireContext = require.context('~/layouts', false, /.*\.vue$/)

const layouts = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)]
  )
  .reduce((components, [name, component]) => {
    components[name] = component.default || component
    return components
  }, {})

export default {
  el: '#app',

  components: {
    Loading,
    Navbar,
    LocaleDropdown,
    UserDropdown
  },

  data: () => ({
    layout: null,
    defaultLayout: 'default',
    drawer: true,
    group: null
  }),

  metaInfo () {
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s · ${appName}`
    }
  },

  mounted () {
    this.$loading = this.$refs.loading
  },

  methods: {
    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
    setLayout (layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout
      }

      this.layout = layouts[layout]
    }
  }
}
</script>
