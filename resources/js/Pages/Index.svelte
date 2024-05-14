<script>
import { useForm } from '@inertiajs/svelte'

// import secretariaLogo from '$lib/images/logo_secretaria-circle-main.png';
import Input from '../components/Input.svelte';
import Alert from "../components/Alert.svelte";
import {displayAlert} from "../stores/alertStore"

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


<Alert />
<main>
	<div class="flex flex-col gap-3 items-center justify-center mb-1 py-6">
		<!-- <img src={secretariaLogo} class="max-w-12 lg:max-w-16" alt="" /> -->
		<h1 class=" text-2xl tracking-widest">Nomina ASCI</h1>
	</div>
	<div class="flex justify-center items-center  w-full">
		<!-- <img src={doctor} class="max-w-96 h-96" alt="" /> -->
	
		<div class="text-center">
			
			<form
      on:submit={handleSubmit}
				class="mx-auto bg-white bg-opacity-5 rounded-lg shadow-2xl p-6 max-w-96  min-w-72 text-center  flex flex-col md:h-96 min-h-96"
			>
				<legend class=" opacity-70 mb-6">INICIAR SESIÓN</legend>
				<div>
          <Input type="text" name="ci" label={"Cédula"} bind:value="{$form.ci}" />
          <Input type="password" name="password" bind:value="{$form.password}" />
				</div>
        <!-- <button type="submit">Iniciar sesión</button> -->
        
				<input
					type="submit"
					class="hover:bg-color3 hover:text-white duration-200 mt-auto w-full bg-color2 text-black font-bold py-3 rounded-md cursor-pointer"
				/>
			</form>
		</div>
		<!-- <img src={ladyDoctor} class="max-w-96 h-96" alt="" /> -->

	
	</div>
</main>

<style>
	.home_container {
		background: rgb(172, 215, 242);
		background: linear-gradient(
			306deg,
			rgba(172, 215, 242, 1) 9%,
			rgba(11, 29, 75, 1) 87%,
			rgba(1, 17, 64, 1) 93%
		);
	}
</style>
