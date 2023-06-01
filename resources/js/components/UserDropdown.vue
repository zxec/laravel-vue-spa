<template>
  <!-- <div>
    <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <img :src="user.photo_url" class="rounded-circle profile-photo me-1">
      {{ user.name }}
    </a>
    <div class="dropdown-menu">
      <router-link :to="{ name: 'settings.profile' }" class="dropdown-item ps-3">
        <fa icon="cog" fixed-width />
        {{ $t('settings') }}
      </router-link>

      <div class="dropdown-divider" />
      <a href="#" class="dropdown-item ps-3" @click.prevent="logout">
        <fa icon="sign-out-alt" fixed-width />
        {{ $t('logout') }}
      </a>
    </div>
  </div> -->
  <v-menu>
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        dark
        v-bind="attrs"
        v-on="on"
      >
        <img :src="user.photo_url" class="rounded-circle profile-photo me-1">
        {{ user.name }}
      </v-btn>
    </template>
    <v-list>
      <v-list-item>
        <router-link :to="{ name: 'settings.profile' }" class="dropdown-item ps-3">
          <fa icon="cog" fixed-width />
          {{ $t('settings') }}
        </router-link>
      </v-list-item>
      <v-list-item>
        <div class="dropdown-divider" />
        <a href="#" class="dropdown-item ps-3" @click.prevent="logout">
          <fa icon="sign-out-alt" fixed-width />
          {{ $t('logout') }}
        </a>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'UserDropdown',

  data: () => ({
    appName: window.config.appName,
    pageUsers: 'Пользователи'
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}

.container {
  max-width: 1100px;
}
</style>
