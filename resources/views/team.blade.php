@extends('layouts.app')
@section('content')
<div class="container">
<div class="row">
<div class="col-sm-12">
<h1 class="page-title mt-3">About the Team</h1> 
    <div class="profiles">
        <p class="para text-justify mx-3">The team behind the development of this River Monitoring System is composed of 5th year computer engineering students at the University of San Carlos. </p>
        <div class="row mt-4">
            <div class="col-6 text-center">
                <img src="/images/jari.jpg" class="pic">
                <p class="font-bold"> Jari Sebastian Mesina </p>
            </div>
            <div class="col-6 text-center d-flex">
                <p class="para text-left align-self-center">  Jari is the Project Manager of Scorpion and 
                    facilitates the work in the group. 
                    He spearheads the web development; specifically, in the backend and database. 
                    He supports his members in any way he can.
                </p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-6 text-center d-flex">
                <p class="para text-left align-self-center">Vanessa is the group's treasurer, making sure that the group
                    always have funds for when materials (and snacks) need to be purchased. She also help jari in web development,
                    specifically in the front-end.</p>
            </div>
            <div class="col-6 text-center">
                <img src="/images/bani.jpg" class="pic">
                <p class="font-bold"> Vanessa Ruth Baylon </p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-6 text-center">
                <img src="/images/ergie.jpg" class="pic">
                <p class="font-bold"> Ergie Empuerto </p>
            </div>
            <div class="col-6 text-center d-flex">
                <p class="para text-left align-self-center"> Ergie works on the documents required for submission by the research course.
                    She also aids in the development of the water level sensor and water velocity meter.</p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-6 text-center d-flex">
                <p class="para text-left align-self-center">Kristal is in-charge of communications. She makes sure the group gets
                    everything we need, from materials and professional aid to support. Kristal also helps in the calculations to obtain the 
                    river volumetric flow rate from the data gathered by the device.</p>
            </div>
            <div class="col-6 text-center">
                <img src="/images/tal.jpg" class="pic">
                <p class="font-bold"> Kristal Kilat </p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-6 text-center">
                <img src="/images/jez.jpg" class="pic">
                <p class="font-bold"> Jezreel Tan </p>
            </div>
            <div class="col-6 text-center d-flex">
                <p class="para text-left align-self-center">Jezreel oversees the design and development of the various prototypes and modules. In addition, he provides insightful input during planning and meetings and leads the testing of the prototypes.</p>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
