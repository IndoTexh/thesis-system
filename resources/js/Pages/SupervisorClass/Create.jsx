import { useForm, usePage } from '@inertiajs/react';
import { useEffect } from 'react';
import toast, { Toaster } from 'react-hot-toast';

const Create = ({ classes, supervisors }) => {
  const { flash } = usePage().props;

  useEffect(() => {
    if (flash?.message) {
      if (flash.code == 200) {
        toast.success(flash.message);
        const audio = new Audio(`/storage/audio/${flash.audio}`);
        audio.play();
      } else {
        toast.error(flash.message);
        const audio = new Audio(`/storage/audio/${flash.audio}`);
        audio.play();
      }
    }
  }, [flash]);

  const supervisorClassForm = useForm({
    classes_id: '',
    supervisor_id: '',
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    supervisorClassForm.post('/admin/create-supervisor-&-class', {
      onFinish: () => {
        supervisorClassForm.reset();
      },
    });
  };


  return (
    <div>
      <Toaster position="top-center" />

     {/* create major section */}
      <div className="bg-white shadow-lg rounded-md p-5 w-xl mb-5">
        <h1 className="text-2xl font-bold mb-6">Create supervisor's class</h1>
        <form onSubmit={handleSubmit} className="space-y-5">
          <div>
            <label className="block mb-1 font-medium">Class</label>
              <select className="w-full border border-gray-300 rounded px-3 py-2"
              value={supervisorClassForm.data.classes_id}
              onChange={(e) => supervisorClassForm.setData('classes_id', e.target.value)}
              >
                <option value="">-- Select Class --</option>
                {classes.map((c) => (
                  <option key={c.id} value={c.id}>{c.class_name}</option>
                ))}
              </select>
            </div>

            <div>
            <label className="block mb-1 font-medium">Supervisor</label>
              <select className="w-full border border-gray-300 rounded px-3 py-2"
              value={supervisorClassForm.data.supervisor_id}
              onChange={(e) => supervisorClassForm.setData('supervisor_id', e.target.value)}
              >
                <option value="">-- Select Supervisor --</option>
                {supervisors.map((s) => (
                  <option key={s.id} value={s.id}>{s.name}</option>
                ))}
              </select>
            </div>

            <button
              type="submit"
              disabled={supervisorClassForm.processing}
              className="bg-blue-600 text-white px-4 py-2 rounded disabled:bg-blue-300"
            >
              {supervisorClassForm.processing ? 'Creating...' : 'Create'}
            </button>
        </form>
      </div>
    </div>
  );
};

export default Create;
