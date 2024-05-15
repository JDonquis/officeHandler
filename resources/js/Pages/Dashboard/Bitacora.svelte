<script>
    import Table from "../../components/Table.svelte";
    import Modal from "../../components/Modal.svelte";
    import Input from "../../components/Input.svelte";

    let showModal = false;

    export let data = [];
    $: console.log(data);
</script>

<Modal bind:showModal>
    <h2 slot="header" class="text-sm text-center">CREAR ACTIVIDAD</h2>

    <form action="">
        <Input
            type="text"
            name="ci"
            required={true}
            label={"Cédula"}
        />
    </form>
</Modal>

<div class="flex justify-between">
    <h1>Bitácora</h1>

    <button class="btn_create" on:click={() => (showModal = true)}
        >Nueva actividad</button
    >
</div>
<Table>
    <thead slot="thead">
        <tr>
            <th>Cod</th>
            <th>Actividad</th>
            <th>Estado</th>
            <th>Ubicación SSF</th>
            <th>Dirección/Oficina </th>
            <th>Porcentaje</th>
            <th>Fecha</th>
            <th>Iniciada en</th>
            <th>Terminada en</th>
            <th scope="col" class="relative py-3.5 px-4">
                <span class="sr-only">Edit</span>
            </th>
        </tr>
    </thead>

    <tbody slot="tbody">
        {#each data.data as row}
            <tr>
                <td>{row.code}</td>
            <td>{row.title}</td>
            <td>
                <div
                    class={`inline px-3 py-1 text-sm font-normal rounded-full dark:bg-gray-800  gap-x-2  ${row.status_id == "1" ? "text-ligthGreen" : "text-gray-400"} `}
                >
                    {row.status_name}
                </div>
            </td>
            <td>{row.location_name}</td>
            <td>{row.office_name}</td>
            <td>{row.progress}</td>
            <td>{row.today_date}</td>
            <td>{row.start_date}</td>
            <td>{row.end_date === null ? 'Sin Finalizar' : row.end_date}</td>
                <td>
                    <button
                        class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"
                            />
                        </svg>
                    </button>
                </td>
            </tr>
        {/each}
    </tbody>
</Table>
