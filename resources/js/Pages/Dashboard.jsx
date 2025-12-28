import { Head } from '@inertiajs/react';

export default function Dashboard({ auth }) {
    return (
        <>
            <Head title="لوحة التحكم" />

            <div className="min-h-screen bg-gray-100">
                <nav className="bg-white border-b border-gray-100">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between h-16">
                            <div className="flex">
                                <div className="shrink-0 flex items-center">
                                    <h1 className="text-xl font-bold">نظام إدارة العقارات</h1>
                                </div>
                            </div>

                            <div className="flex items-center">
                                <span className="text-gray-700">{auth.user.name}</span>
                            </div>
                        </div>
                    </div>
                </nav>

                <header className="bg-white shadow">
                    <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 className="font-semibold text-3xl text-gray-800 leading-tight">
                            لوحة التحكم
                        </h2>
                    </div>
                </header>

                <main>
                    <div className="py-12">
                        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div className="p-6 text-gray-900">
                                    مرحباً بك في نظام إدارة العقارات!
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </>
    );
}
