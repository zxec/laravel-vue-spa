<template>
  <card :title="$t('users')">
    <div class="mb-3 row">
      <div class="d-flex">
        <router-link :to="{ name: 'users.create' }">
          <v-button type="success">
            <fa :icon="icons.create" fixed-width />
          </v-button>
        </router-link>
      </div>
    </div>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">
            #
          </th>
          <th scope="col">
            {{ $t('name') }}
          </th>
          <th scope="col">
            {{ $t('email') }}
          </th>
          <th scope="col">
            {{ $t('created_at') }}
          </th>
          <th scope="col">
            {{ $t('updated_at') }}
          </th>
          <th class="text-center">
            {{ $t('actions') }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <th scope="row">
            {{ user.id }}
          </th>
          <td>
            {{ user.name }}
          </td>
          <td>
            {{ user.email }}
          </td>
          <td>
            {{ user.created_at }}
          </td>
          <td>
            {{ user.updated_at }}
          </td>
          <td class="d-flex justify-content-center">
            <div>
              <router-link :to="{ name: 'users.edit', params: { id: user.id }}">
                <button class="btn btn-success">
                  <fa :icon="icons.edit" fixed-width />
                </button>
              </router-link>
            </div>
            <div>
              <button class="btn btn-danger ms-3" @click="del(user.id)">
                <fa :icon="icons.delete" fixed-width />
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </card>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data () {
    return {
      icons: {
        create: 'plus',
        edit: 'pen',
        delete: 'trash'
      }
    }
  },

  computed: mapGetters({
    users: 'users/users'
  }),

  created () {
    this.index()
  },

  methods: {
    async index () {
      const { data } = await axios.get('/api/users')
      this.$store.dispatch('users/indexUsers', { users: data })
    },
    async del (id) {
      const { data } = await axios.delete(`/api/users/${id}`)
      if (typeof data.error === 'undefined') {
        this.$store.dispatch('users/deleteUser', { users: data })
      }
    }
  }
}
</script>

<style>
  .table thead th {
    height: 41px;
  }
</style>
