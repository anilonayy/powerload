import axios from '@/utils/appAxios';

const getAllWorkouts = async () =>  await axios.get('v1/workouts');

const getAllWorkoutsWithDetails = async () =>  await axios.get('v1/workouts/details');

const getWorkout = async (id) => await axios.get(`v1/workouts/${id}`);

const createWorkout = async (workout) => await axios.post('v1/workouts', { train: workout });

const updateWorkout = async (id, workout) => await axios.put(`v1/workouts/${id}`, { train: workout });

const deleteWorkout = async (id) => await axios.delete(`v1/workouts/${id}`);

export default {
    getAllWorkouts,
    getAllWorkoutsWithDetails,
    getWorkout,
    deleteWorkout,
    createWorkout,
    updateWorkout
}