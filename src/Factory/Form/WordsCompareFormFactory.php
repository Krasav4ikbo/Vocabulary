<?php

namespace App\Factory\Form;

use App\Form\Word\WordsCompareForm;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Validator\Validation;

class WordsCompareFormFactory
{
    public function create($data, $action): FormInterface
    {
        $validator = Validation::createValidator();

        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new ValidatorExtension($validator))
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();

        return $formFactory->create(WordsCompareForm::class, $data,
            [
                'attr' => ['class' => 'form-signin m-auto'],
                'action' => $action,
            ]);
    }
}
