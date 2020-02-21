<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\GeoClient;
use App\Service\DistanceHelper;
use App\Form\Type\AddressType;
use Symfony\Component\HttpFoundation\Request;

class AddressController extends AbstractController
{
 
    /**
     * @Route("/address")
     * 
     * Form to calculate the distance between a postal address
     * and an IP address
     */
 
    public function distanceTool()
    {

        $form = $this->createForm(AddressType::class, null, [
            'action' => $this->generateUrl('app_address_process'),
        ]);

        
        return $this->render('address/index.html.twig', [ "form" => $form->createView()]);
    }

    /**
     * @Route("/address/process")
     * 
     * Processing the distance calcul with call to external apis
     * If errors occurs display the form again
     */
 
    public function process(Request $request, GeoClient $geoClient, DistanceHelper $helper)
    {
    
        $form = $this->createForm(AddressType::class, null, [
            'action' => $this->generateUrl('app_address_process'),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $res = $form->getData();

            $address = $res['number']." ".
                $res['voie'].", ".
                $res['postal_code']." ".
                $res['city']." ".
                $res['country'];

            $ip = $res['ip'];

            $coord1 = $geoClient->getLatLonByAddress($address);
            $coord2 = $geoClient->getLatLonByIp($ip);

            $distance = $helper->distance($coord1['lat'], $coord1['lng'], $coord2['lat'], $coord2['lng']);

            return $this->redirectToRoute('app_address_success', ["distance"=>$distance]);
        }

        return $this->render('address/index.html.twig', [ "form" => $form->createView()]);

    }

    /**
     * @Route("/address/success")
     * 
     * Display the distance calculated after a valide processing
     */
 
    public function success(Request $request)
    {
        $distance = $request->query->get('distance');
        
        return $this->render('address/success.html.twig', [ "distance" => $distance]);
    }
}