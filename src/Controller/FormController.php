<?php

namespace App\Controller;

use App\Entity\RecruitmentTask;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;

class FormController extends AbstractController
{
    public function new(Request $request)
    {
        // Create form with event listener calculating result
        // and placing it in 'output' NumberType field.
        $form = $this->createFormBuilder()
            ->add('input', NumberType::class)
            ->add('output', NumberType::class, array(
                'attr' => array(
                    'readonly' => true,
                )))
            ->add('compute', SubmitType::class)
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();
                // Calculate result
                if (isset($data['input'])) {
                    $value = (new RecruitmentTask())->getMaxOfSeries($data['input']);

                    // Set result, otherwise clear 'output'
                    if ($this->isResultValid($value))
                        $data['output'] = $value;
                    else
                        unset($data['output']);

                    $event->setData($data);
                }
            })
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recTask = new RecruitmentTask();
            $data = $form->getData();
            $value = $recTask->getMaxOfSeries($data['input']);
        }

        // Render form
        return $this->render('task/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function isResultValid($value)
    {
        return $value !== null;
    }
}