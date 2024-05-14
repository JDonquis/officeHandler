<script>
    import Table from "../../components/Table.svelte";
    // export const data = [
    //     {
    //         id: 42,
    //         code: 3,
    //         status: "En desarrollo",
    //         title: "dasda",
    //         user_id: 1,
    //         today_date: "2024-05-03",
    //         start_date: "2024-05-03",
    //         end_date: null,
    //         location_id: 1,
    //         office_id: 3,
    //         division_id: 2,
    //         department_id: 1,
    //         progress: 0,
    //         observation: "dasdas",
    //         user_name: "Juan",
    //         user_last_name: "Donquis",
    //         location_name: "Despacho Secretaría de Salud",
    //         office_name: "Oficina de Comunicación y Relaciones Institucionales",
    //         division_name: "División  de Audiovisual",
    //         deparment_id: 1,
    //         department_name: "Sin Asignar",
    //     },
    //     {
    //         id: 40,
    //         code: 2,
    //         status: "Finalizada",
    //         title: "xaxa",
    //         user_id: 1,
    //         today_date: "2024-05-03",
    //         start_date: "2024-05-03",
    //         end_date: "2024-05-03",
    //         location_id: 1,
    //         office_id: 1,
    //         division_id: 1,
    //         department_id: 1,
    //         progress: 100,
    //         observation: "xaxa",
    //         user_name: "Juan",
    //         user_last_name: "Donquis",
    //         location_name: "Despacho Secretaría de Salud",
    //         office_name: "Sin Asignar",
    //         division_name: "Sin Asignar",
    //         deparment_id: 1,
    //         department_name: "Sin Asignar",
    //     },
    //     {
    //         id: 39,
    //         code: 2,
    //         status: "En desarrollo",
    //         title: "xaxa",
    //         user_id: 1,
    //         today_date: "2024-05-03",
    //         start_date: "2024-05-03",
    //         end_date: null,
    //         location_id: 1,
    //         office_id: 1,
    //         division_id: 1,
    //         department_id: 1,
    //         progress: 0,
    //         observation: "xaxa",
    //         user_name: "Juan",
    //         user_last_name: "Donquis",
    //         location_name: "Despacho Secretaría de Salud",
    //         office_name: "Sin Asignar",
    //         division_name: "Sin Asignar",
    //         deparment_id: 1,
    //         department_name: "Sin Asignar",
    //     },
    //     {
    //         id: 38,
    //         code: 1,
    //         status: "En desarrollo",
    //         title: "Juan",
    //         user_id: 1,
    //         today_date: "2024-05-03",
    //         start_date: "2024-05-03",
    //         end_date: "",
    //         location_id: 1,
    //         office_id: 1,
    //         division_id: 1,
    //         department_id: 1,
    //         progress: 22,
    //         observation: "asda",
    //         user_name: "Juan",
    //         user_last_name: "Donquis",
    //         location_name: "Despacho Secretaría de Salud",
    //         office_name: "Sin Asignar",
    //         division_name: "Sin Asignar",
    //         deparment_id: 1,
    //         department_name: "Sin Asignar",
    //     },
    //     {
    //         id: 35,
    //         code: 1,
    //         status: "En desarrollo",
    //         title: "Juan",
    //         user_id: 1,
    //         today_date: "2024-05-03",
    //         start_date: "2024-05-03",
    //         end_date: null,
    //         location_id: 1,
    //         office_id: 1,
    //         division_id: 1,
    //         department_id: 1,
    //         progress: 0,
    //         observation: "asda",
    //         user_name: "Juan",
    //         user_last_name: "Donquis",
    //         location_name: "Despacho Secretaría de Salud",
    //         office_name: "Sin Asignar",
    //         division_name: "Sin Asignar",
    //         deparment_id: 1,
    //         department_name: "Sin Asignar",
    //     },
    // ];
    
    export let data = [];
    console.log(data);
</script>

<h1>Bitácora</h1>
<Table>
    <thead slot="thead">
        <tr>
            <th> Cod </th>
            <th> Nombre de la actividd </th>
            <th> Estado </th>
            <th> Ubicacion SSF </th>
            <th scope="col" class="relative py-3.5 px-4">
                <span class="sr-only">Edit</span>
            </th>
        </tr>
    </thead>

    <tbody slot="tbody">
        {#each data as row}
        <tr>
            <td> {row.code}</td>
            <td> {row.title}</td>
            <td>
                <div class={`inline px-3 py-1 text-sm font-normal rounded-full dark:bg-gray-800  gap-x-2  ${row.status_id == "1" ? 'text-ligthGreen' : 'text-gray-400'} `}>
                    {row.status_id}
                </div>
            </td>
            <td> {row.location_name}</td>
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
