<script>
import { useForm } from '@inertiajs/svelte'

let form = useForm({
  ci: null,
  password: null,
})

function handleSubmit(event) {
  event.preventDefault();

  $form.post('/login', {
  ci: this.ci,
  password: this.password,
})

}
</script>

<div class="flex flex-col items-center text-center space-y-4">
    <h1 class="block mt-4 font-bold text-4xl">Login</h1>
    <form method="post" action="/login" on:submit="{handleSubmit}">
         <input type="text" name="ci" bind:value="{$form.ci}">
        <input type="password" name="password" bind:value="{$form.password}">
        <button type="submit">Iniciar sesión</button>
      </form>

</div>
