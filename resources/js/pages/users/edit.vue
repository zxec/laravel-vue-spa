<template>
  <form-user :title="$t('update')" :user="user" @change="update" />
</template>

<script>
import { mapGetters } from 'vuex'
import FormUser from '~/components/FormUser'

export default {
  components: {
    FormUser
  },

  middleware: 'auth',

  computed: mapGetters({
    users: 'users/users'
  }),

  created () {
    this.user = this.users.find(user => user.id === this.$route.params.id)
  },

  methods: {
    async update (form) {
      const { data } = await form.patch(`/api/users/${this.$route.params.id}`)
      await this.$store.dispatch('users/updateUser', { user: data })
      this.$router.push({ name: 'users.index' })
    }
  }
}
</script>
