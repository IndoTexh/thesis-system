import { Link, useForm, usePage } from '@inertiajs/react';
import { PrimeReactProvider } from "@primereact/core"
import Aura from '@primeuix/themes/aura';
import { InputText } from 'primereact/inputtext';
import { useEffect } from 'react';
import toast, { Toaster } from 'react-hot-toast';

const Create = () => {

  const { flash } = usePage().props;

  useEffect(() => {
    if(flash?.message) {
      toast.success(flash.message);
    }
  }, [flash]);

  const theme = {
    preset: Aura,
};

  const { data, setData, post, processing, errors } = useForm({
    title: '',
    abstract: '',
    document: null,
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/student/theses/upload', {
      onSuccess: () => {
        data.title = '',
        data.abstract = '',
        data.document = null
      },
      forceFormData: true, 
    });
  };

  return (
   <PrimeReactProvider theme={theme}>
    <Toaster position='top-center'/>
     <div className="max-w-2xl mx-auto mt-10 p-6 bg-white rounded shadow">
      <h1 className="text-2xl font-bold mb-6">Upload Thesis</h1>
    {/*   <InputText placeholder="Enter text" /> */}
      <form onSubmit={handleSubmit} className="space-y-5">
        <div>
          <label className="block mb-1 font-medium">Title</label>
          <input
            type="text"
            value={data.title}
            onChange={(e) => setData('title', e.target.value)}
            className="w-full border border-gray-300 rounded px-3 py-2"
          />
          {errors.title && <p className="text-red-500 text-sm mt-1">{errors.title}</p>}
        </div>

        {/* Abstract */}
        <div>
          <label className="block mb-1 font-medium">Abstract</label>
          <textarea
            value={data.abstract}
            onChange={(e) => setData('abstract', e.target.value)}
            className="w-full border border-gray-300 rounded px-3 py-2 h-32"
          />
          {errors.abstract && <p className="text-red-500 text-sm mt-1">{errors.abstract}</p>}
        </div>

        {/* File Upload */}
        <div>
          <label className="block mb-1 font-medium">Upload Thesis Document (PDF only)</label>
          <input
            type="file"
            accept=".pdf"
            onChange={(e) => setData('document', e.target.files[0])}
            className="w-full"
          />
          {errors.document && <p className="text-red-500 text-sm mt-1">{errors.document}</p>}
        </div>

        {/* Submit */}
        <button
          type="submit"
          disabled={processing}
          className="bg-blue-600 text-white px-4 py-2 rounded disabled:bg-blue-300"
        >
          {processing ? 'Uploading...' : 'Submit Thesis'}
        </button>
      </form>
    </div>
   </PrimeReactProvider>
  );
};

export default Create;
