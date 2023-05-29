<template :title="title">
  <div class="row">
    <div class="col-lg-7 m-auto">
      <card :title="title">
        <form @submit.prevent="`${action}`" @keydown="form.onKeydown($event)">
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="name" />
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email" />
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">{{ $t('password') }}</label>
            <div class="col-md-7">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="form" field="password" />
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">{{ $t('confirm_password') }}</label>
            <div class="col-md-7">
              <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
              <has-error :form="form" field="password_confirmation" />
            </div>
          </div>
          <div class="mb-3 row">
            <div class="col-md-7 offset-md-3 d-flex">
              <v-button :loading="form.busy">
                {{ title }}
              </v-button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  name: 'FormUser',

  middleware: 'auth',

  props: {
    user: { type: Object, default: null },
    title: { type: String, default: null },
    action: { type: String, default: null }
  },

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  created () {
    this.form.name = this.user.name
    this.form.email = this.user.email
  },

  methods: {
    async update () {
      const { data } = await this.form.patch(`/api/users/${this.$route.params.id}`)
      await this.$store.dispatch('users/updateUser', { user: data })
      this.$router.push({ name: 'users.index' })
    },
    async create () {
      const { data } = await this.form.post('/api/users')
      await this.$store.dispatch('users/createUser', { user: data })
      this.$router.push({ name: 'users.index' })
    }
  }
}
</script>
