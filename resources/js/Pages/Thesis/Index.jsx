import { Link, useForm, usePage } from '@inertiajs/react';
import { PrimeReactProvider } from "@primereact/core"
import Aura from '@primeuix/themes/aura';
import { useEffect } from 'react';
import toast, { Toaster } from 'react-hot-toast';

const Index = ({ theses }) => {

  const audio = new Audio('/storage/audio/success_audio.mp3');
  const { flash } = usePage().props;

  useEffect(() => {
    if(flash?.message) {
      toast.success(flash.message);
      audio.play();
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

   const formatDate = (originalDate) => {
    const date = new Date(originalDate);
    return date.toLocaleDateString("en-US")
   }

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/thesis/upload', {
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
    <div className='flex items-center space-x-4 mb-5'>
      <h1 className="text-2xl font-bold">My theses</h1>
    <Link href="/student/theses/upload" className='text-blue-600 hover:underline font-medium'>Upload thesis</Link>
    </div>
     <div className="w-4xl mx-auto grid grid-cols-3 space-y-2 gap-2">
      {theses.map((thesis) => (
        <div key={thesis.id} className='bg-white shadow-lg shadow-gray-400 rounded-md px-4 py-4 space-y-2'>
          <div>
            <img src={`/storage/${thesis.user.profile_picture}`} alt="profile" className='w-8 h-8 rounded-full'/>
          </div>
          <div>
            <span className='font-medium text-md text-gray-400'>Theses holder: </span>
            <span className='font-medium text-blue-600'>
              { thesis.user.name }
            </span>
          </div>
          <div>
            <span className='font-medium text-md text-gray-400'>Title: </span>
            <span className='font-medium text-blue-600'>{thesis.title}</span>
          </div>
          <div>
            <span className='font-medium text-md text-gray-400'>Current status: </span>
            <span className='font-medium text-blue-600'>{thesis.status}</span>
          </div>
          <div>
            <span className='font-medium text-md text-gray-400'>Date of submission: </span>
            <span className='font-medium text-blue-600'>{formatDate(thesis.created_at)}</span>
          </div>
          <div className='flex space-x-3  flex-col space-y-1'>
            <a 
              href={`/storage/${thesis.file_path}`}
              target='_blank'
              rel='noopener noreferrer'
              className="font-medium text-md text-gray-400 flex items-center space-x-2 hover:underline"
              >
                <span>Preview</span>
                <i className="fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
            </a>
             <a
                href={`/storage/${thesis.file_path}`}
                download
                className="font-medium text-md text-gray-400 flex items-center space-x-2 hover:underline"
              >
                <span>Download</span>
                <i className="fa-solid fa-file-export text-blue-600"></i>
              </a>
          </div>
          <div>
            <Link 
            href={`/student/theses/${thesis.id}/edit`}
            className='px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm'>
            Edit
            </Link>
          </div>
        </div>
      ))}
    </div>
   </PrimeReactProvider>
  );
};

export default Index;
