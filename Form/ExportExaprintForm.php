<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace DpdClassic\Form;

use DpdClassic\Controller\ExportExaprintController;
use DpdClassic\DpdClassic;
use DpdClassic\Model\DpdClassicSenderConfigQuery;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Class ExportExaprintForm
 * @package DpdClassic\Form
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class ExportExaprintForm extends BaseForm
{
    public static function getName()
    {
        return "export_exaprint_form";
    }

    protected function buildForm()
    {
        $senderConfig = DpdClassicSenderConfigQuery::create()->findOne();

        $this->formBuilder
            ->add(
                'name',
                TextType::class,
                array(
                    'label' => Translator::getInstance()->trans('Sender\'s name', [], DpdClassic::DOMAIN_NAME),
                    'data' => $senderConfig ? $senderConfig->getName() : '',
                    'constraints' => array(new NotBlank()),
                    'label_attr' => array(
                        'for' => 'name'
                    )
                )
            )
            ->add(
                'addr',
                TextType::class,
                array(
                    'label' => Translator::getInstance()->trans('Sender\'s address1', [], DpdClassic::DOMAIN_NAME),
                    'data' => $senderConfig ? $senderConfig->getPrimaryAdress() : '',
                    'constraints' => array(new NotBlank()),
                    'label_attr' => array(
                        'for' => 'addr'
                    )
                )
            )
            ->add(
                'addr2',
                TextType::class,
                array(
                    'label' => Translator::getInstance()->trans('Sender\'s address2', [], DpdClassic::DOMAIN_NAME),
                    'data' =>  $senderConfig ? $senderConfig->getSecondaryAdress() : '',
                    'label_attr' => array(
                        'for' => 'addr2'
                    )
                )
            )
            ->add(
                'zipcode',
                TextType::class,
                array(
                    'label' => Translator::getInstance()->trans('Sender\'s zipcode', [], DpdClassic::DOMAIN_NAME),
                    'data' => $senderConfig ? $senderConfig->getZipcode() : '',
                    'constraints' => array(new NotBlank(), new Regex(['pattern' => "/^(2[A-B])|([0-9]{2})\d{3}$/"])),
                    'label_attr' => array(
                        'for' => 'zipcode'
                    )
                )
            )
            ->add(
                'city',
                TextType::class,
                array(
                    'label' => Translator::getInstance()->trans('Sender\'s city', [], DpdClassic::DOMAIN_NAME),
                    'data' => $senderConfig ? $senderConfig->getCity() : '',
                    'constraints' => array(new NotBlank()),
                    'label_attr' => array(
                        'for' => 'city'
                    )
                )
            )
            ->add(
                'tel',
                TextType::class,
                array(
                    'label' => Translator::getInstance()->trans('Sender\'s phone', [], DpdClassic::DOMAIN_NAME),
                    'data' => $senderConfig ? $senderConfig->getPhone() : '',
                    'constraints' => array(new NotBlank(), new Regex(['pattern' => "/^0[1-9]\d{8}$/"])),
                    'label_attr' => array(
                        'for' => 'tel'
                    )
                )
            )
            ->add(
                'mobile',
                TextType::class,
                array(
                    'label' => Translator::getInstance()->trans('Sender\'s mobile phone', [], DpdClassic::DOMAIN_NAME),
                    'data' => $senderConfig ? $senderConfig->getMobilePhone() : '',
                    'constraints' => array(new NotBlank(), new Regex(['pattern' => "#^0[6-7]{1}\d{8}$#"])),
                    'label_attr' => array(
                        'for' => 'mobile'
                    )
                )
            )
            ->add(
                'mail',
                EmailType::class,
                array(
                    'label' => Translator::getInstance()->trans('Sender\'s email', [], DpdClassic::DOMAIN_NAME),
                    'data' => $senderConfig ? $senderConfig->getEmail() : '',
                    'constraints' => array(new NotBlank()),
                    'label_attr' => array(
                        'for' => 'mail'
                    )
                )
            )
            ->add(
                'expcode',
                PasswordType::class,
                array(
                    'label' => Translator::getInstance()->trans('DpdClassic Sender\'s code', [], DpdClassic::DOMAIN_NAME),
                    'constraints' => array(new NotBlank(), new Regex(['pattern' => "#^\d{8}$#"])),
                    'data' => $senderConfig ? $senderConfig->getDpdCode() : '',
                    'label_attr' => array(
                        'for' => 'expcode'
                    )
                )
            );
    }
}
