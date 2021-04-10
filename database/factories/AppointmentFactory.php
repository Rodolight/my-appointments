<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;


class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $doctorIds = User::doctors()->pluck('id');
        $patientIds = User::patients()->pluck('id');

        $scheduled = $this->faker->dateTimeBetween('-1 years', 'now');
        $scheduled_date = $scheduled->format('Y-m-d');
        $scheduled_time = $scheduled->format('H:i:s');
        
        $types = ['Consulta','Exámen','Operación'];
        $status = ['Atendida', 'Cancelada'];
        return [
            'description' => $this->faker->sentence(5),
            'specialty_id' => $this->faker->numberBetween(1,4),
            'doctor_id' => $this->faker->randomElement($doctorIds),
            'patient_id' => $this->faker->randomElement($patientIds),
            'schedule_date' => $scheduled_date,
            'schedule_time' => $scheduled_time,
            'type' => $this->faker->randomElement($types),
            'status' => $this->faker->randomElement($status)
        ];
    }
}
