import { useForm, usePage } from '@inertiajs/react';
import { useEffect } from 'react';
import toast, { Toaster } from 'react-hot-toast';

const Create = ({ majors }) => {
  const { flash } = usePage().props;

  useEffect(() => {
    if (flash?.message) {
      toast.success(flash.message);

      if (flash.audio) {
        const audio = new Audio(`/storage/audio/${flash.audio}`);
        audio.play().catch((err) => {
          console.error('Audio playback failed:', err);
        });
      }
    }
  }, [flash]);

  const majorForm = useForm({
    major_name: '',
  });

  const classForm = useForm({
    class_name: '',
    major_id: '',
  });

  const handleSubmitMajor = (e) => {
    e.preventDefault();
    majorForm.post('/admin/create-major', {
      onFinish: () => {
        majorForm.reset();
      },
    });
  };

  const handleSubmitClass = (e) => {
    e.preventDefault();
    classForm.post('/admin/create-class', {
      onFinish: () => {
        classForm.reset();
      },
    });
  };

  return (
    <div>
      <Toaster position="top-center" />

     {/* create major section */}
      <div className="bg-white shadow-lg rounded-md p-5 w-xl mb-5">
        <h1 className="text-2xl font-bold mb-6">Create major</h1>
        <form onSubmit={handleSubmitMajor} className="space-y-5">
          <div>
            <label className="block mb-1 font-medium">Major Name</label>
              <input
                type="text"
                value={majorForm.data.major_name}
                onChange={(e) => majorForm.setData('major_name', e.target.value)}
                className="w-full border border-gray-300 rounded px-3 py-2"
              />
              {majorForm.errors.major_name && (
                <p className="text-red-500 text-sm mt-1">{majorForm.errors.major_name}</p>
              )}
            </div>

            <button
              type="submit"
              disabled={majorForm.processing}
              className="bg-blue-600 text-white px-4 py-2 rounded disabled:bg-blue-300"
            >
              {majorForm.processing ? 'Creating...' : 'Create'}
            </button>
        </form>
      </div>

      {/* create class section */}
      <div className="bg-white shadow-lg rounded-md p-5 w-xl mb-5">
        <h1 className="text-2xl font-bold mb-6">Create class</h1>
        <form onSubmit={handleSubmitClass} className="space-y-5">
          <div>
            <label className="block mb-1 font-medium">Select major</label>
            <select
              value={classForm.data.major_id}
              onChange={(e) => classForm.setData('major_id', e.target.value)}
              className="w-full border border-gray-300 rounded px-3 py-2"
            >
              <option value="">-- Select Major --</option>
              {majors.map((major) => (
                <option key={major.id} value={major.id}>
                  {major.major_name}
                </option>
              ))}
            </select>
            {classForm.errors.major_id && (
              <p className="text-red-500 text-sm mt-1">{classForm.errors.major_id}</p>
            )}
          </div>

          <div>
            <label className="block mb-1 font-medium">Class Name</label>
            <input
              type="text"
              value={classForm.data.class_name}
              onChange={(e) => classForm.setData('class_name', e.target.value)}
              className="w-full border border-gray-300 rounded px-3 py-2"
            />
            {classForm.errors.class_name && (
              <p className="text-red-500 text-sm mt-1">{classForm.errors.class_name}</p>
            )}
          </div>

          <button
            type="submit"
            disabled={classForm.processing}
            className="bg-blue-600 text-white px-4 py-2 rounded disabled:bg-blue-300"
          >
            {classForm.processing ? 'Creating...' : 'Create'}
          </button>
        </form>
      </div>

      
    </div>
  );
};

export default Create;
