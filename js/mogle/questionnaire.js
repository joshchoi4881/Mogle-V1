$(function() {
  $(".specificSkills").hide();
  $(".gig").hide();
  $("#COVID-19").change(function() {
    if ($(this).is(":checked")) {
      if ($("#RideshareOption").is(":checked")) {
        $("#RideshareOption").click();
      }
      $("#rideshareDiv").hide();
      if ($("#HandyOption").is(":checked")) {
        $("#HandyOption").click();
      }
      $("#HandyDiv").hide();
      if ($("#WagOption").is(":checked")) {
        $("#WagOption").click();
      }
      if ($("#RoverOption").is(":checked")) {
        $("#RoverOption").click();
      }
      if ($("#CareOption").is(":checked")) {
        $("#CareOption").click();
      }
      $("#specificCare").hide();
      if ($("#care").is(":checked")) {
        $("#care").click();
      }
      $("#careDiv").hide();
      if ($("#massage").is(":checked")) {
        $("#massage").click();
      }
      $("#massageDiv").hide();
      if ($("#GigFinesseOption").is(":checked")) {
        $("#GigFinesseOption").click();
      }
      $("#GigFinesseDiv").hide();
      if ($("#AssetCarOption").is(":checked")) {
        $("#AssetCarOption").click();
      }
      if ($("#AirbnbOption").is(":checked")) {
        $("#AirbnbOption").click();
      }
      $("#assets").hide();
    } else {
      $("#rideshareDiv").show();
      $("#HandyDiv").show();
      $("#careDiv").show();
      $("#massageDiv").show();
      $("#GigFinesseDiv").show();
      $("#assets").show();
    }
  });
  $("#driving").change(function() {
    if ($(this).is(":checked")) {
      $("#specificDriving").show();
    } else {
      if ($("#RideshareOption").is(":checked")) {
        $("#RideshareOption").click();
      }
      if ($("#DeliveryOption").is(":checked")) {
        $("#DeliveryOption").click();
      }
      if ($("#FoodDeliveryOption").is(":checked")) {
        $("#FoodDeliveryOption").click();
      }
      if ($("#GroceryDeliveryOption").is(":checked")) {
        $("#GroceryDeliveryOption").click();
      }
      $("#specificDriving").hide();
    }
  });
  $("#labor").change(function() {
    if ($(this).is(":checked")) {
      $("#specificLabor").show();
    } else {
      if ($("#AmazonDeliversWarehouseOption").is(":checked")) {
        $("#AmazonDeliversWarehouseOption").click();
      }
      if ($("#DollyHandsOption").is(":checked")) {
        $("#DollyHandsOption").click();
      }
      if ($("#TaskEasyOption").is(":checked")) {
        $("#TaskEasyOption").click();
      }
      if ($("#HandyOption").is(":checked")) {
        $("#HandyOption").click();
      }
      $("#specificLabor").hide();
    }
  });
  $("#care").change(function() {
    if ($(this).is(":checked")) {
      $("#specificCare").show();
    } else {
      if ($("#WagOption").is(":checked")) {
        $("#WagOption").click();
      }
      if ($("#RoverOption").is(":checked")) {
        $("#RoverOption").click();
      }
      if ($("#CareOption").is(":checked")) {
        $("#CareOption").click();
      }
      $("#specificCare").hide();
    }
  });
  $("#massage").change(function() {
    if ($(this).is(":checked")) {
      $("#specificMassage").show();
    } else {
      if ($("#ZeelOption").is(":checked")) {
        $("#ZeelOption").click();
      }
      $("#specificMassage").hide();
    }
  });
  $("#language").change(function() {
    if ($(this).is(":checked")) {
      $("#specificLanguage").show();
    } else {
      if ($("#LanguageFreelancerOption").is(":checked")) {
        $("#LanguageFreelancerOption").click();
      }
      if ($("#TranslateOption").is(":checked")) {
        $("#TranslateOption").click();
      }
      if ($("#ItalkiOption").is(":checked")) {
        $("#ItalkiOption").click();
      }
      $("#specificLanguage").hide();
    }
  });
  $("#writing").change(function() {
    if ($(this).is(":checked")) {
      $("#specificWriting").show();
    } else {
      if ($("#WritingFreelancerOption").is(":checked")) {
        $("#WritingFreelancerOption").click();
      }
      if ($("#WritingUpworkOption").is(":checked")) {
        $("#WritingUpworkOption").click();
      }
      if ($("#WritingFiverrOption").is(":checked")) {
        $("#WritingFiverrOption").click();
      }
      $("#specificWriting").hide();
    }
  });
  $("#art").change(function() {
    if ($(this).is(":checked")) {
      $("#specificArt").show();
    } else {
      if ($("#ArtGraphicsFiverrOption").is(":checked")) {
        $("#ArtGraphicsFiverrOption").click();
      }
      if ($("#ArtVideoFiverrOption").is(":checked")) {
        $("#ArtVideoFiverrOption").click();
      }
      if ($("#EtsyOption").is(":checked")) {
        $("#EtsyOption").click();
      }
      $("#specificArt").hide();
    }
  });
  $("#music").change(function() {
    if ($(this).is(":checked")) {
      $("#specificMusic").show();
    } else {
      if ($("#BeatStarsOption").is(":checked")) {
        $("#BeatStarsOption").click();
      }
      if ($("#MusicFiverrOption").is(":checked")) {
        $("#MusicFiverrOption").click();
      }
      if ($("#GigFinesseOption").is(":checked")) {
        $("#GigFinesseOption").click();
      }
      $("#specificMusic").hide();
    }
  });
  $("#finance").change(function() {
    if ($(this).is(":checked")) {
      $("#specificFinance").show();
    } else {
      if ($("#FinanceUpworkOption").is(":checked")) {
        $("#FinanceUpworkOption").click();
      }
      if ($("#GraphiteOption").is(":checked")) {
        $("#GraphiteOption").click();
      }
      $("#specificFinance").hide();
    }
  });
  $("#tech").change(function() {
    if ($(this).is(":checked")) {
      $("#specificTech").show();
    } else {
      if ($("#WebFreelancerOption").is(":checked")) {
        $("#WebFreelancerOption").click();
      }
      if ($("#MobileFreelancerOption").is(":checked")) {
        $("#MobileFreelancerOption").click();
      }
      if ($("#ITUpworkOption").is(":checked")) {
        $("#ITUpworkOption").click();
      }
      if ($("#WebUpworkOption").is(":checked")) {
        $("#WebUpworkOption").click();
      }
      if ($("#DataUpworkOption").is(":checked")) {
        $("#DataUpworkOption").click();
      }
      if ($("#TechFiverrOption").is(":checked")) {
        $("#TechFiverrOption").click();
      }
      $("#specificTech").hide();
    }
  });
  $("#engineering").change(function() {
    if ($(this).is(":checked")) {
      $("#specificEngineering").show();
    } else {
      if ($("#EngineeringFreelancerOption").is(":checked")) {
        $("#EngineeringFreelancerOption").click();
      }
      if ($("#EngineeringUpworkOption").is(":checked")) {
        $("#EngineeringUpworkOption").click();
      }
      $("#specificEngineering").hide();
    }
  });
  $("#business").change(function() {
    if ($(this).is(":checked")) {
      $("#specificBusiness").show();
    } else {
      if ($("#SalesFreelancerOption").is(":checked")) {
        $("#SalesFreelancerOption").click();
      }
      if ($("#BusinessFreelancerOption").is(":checked")) {
        $("#BusinessFreelancerOption").click();
      }
      if ($("#SalesUpworkOption").is(":checked")) {
        $("#SalesUpworkOption").click();
      }
      if ($("#MarketingFiverrOption").is(":checked")) {
        $("#MarketingFiverrOption").click();
      }
      if ($("#BusinessFiverrOption").is(":checked")) {
        $("#BusinessFiverrOption").click();
      }
      $("#specificBusiness").hide();
    }
  });
  $("#legal").change(function() {
    if ($(this).is(":checked")) {
      $("#specificLegal").show();
    } else {
      if ($("#LegalUpworkOption").is(":checked")) {
        $("#LegalUpworkOption").click();
      }
      $("#specificLegal").hide();
    }
  });
  // Driving
  $("#RideshareOption").change(function() {
    if ($(this).is(":checked")) {
      $(".UberCard").show();
      $(".LyftCard").show();
      $(".HopSkipDriveCard").show();
    } else {
      $(".UberCard").hide();
      $(".LyftCard").hide();
      $(".HopSkipDriveCard").hide();
    }
  });
  $("#DeliveryOption").change(function() {
    if ($(this).is(":checked")) {
      $(".AmazonDeliversDeliveryCard").show();
      $(".AmazonFlexDeliveryCard").show();
      $(".DollyHelpersCard").show();
    } else {
      $(".AmazonDeliversDeliveryCard").hide();
      $(".AmazonFlexDeliveryCard").hide();
      $(".DollyHelpersCard").hide();
    }
  });
  $("#FoodDeliveryOption").change(function() {
    if ($(this).is(":checked")) {
      $(".Uber_EatsCard").show();
      $(".GrubhubCard").show();
      $(".DoorDashCard").show();
      $(".CaviarCard").show();
      $(".PostmatesCard").show();
      $(".WaitrCard").show();
      $(".Bite_SquadCard").show();
      $(".FavorCard").show();
      $(".Food_DudesCard").show();
      $(".FoodjetsCard").show();
    } else {
      $(".Uber_EatsCard").hide();
      $(".GrubhubCard").hide();
      $(".DoorDashCard").hide();
      $(".CaviarCard").hide();
      $(".PostmatesCard").hide();
      $(".WaitrCard").hide();
      $(".Bite_SquadCard").hide();
      $(".FavorCard").hide();
      $(".Food_DudesCard").hide();
      $(".FoodjetsCard").hide();
    }
  });
  $("#GroceryDeliveryOption").change(function() {
    if ($(this).is(":checked")) {
      $(".AmazonDeliversShopperCard").show();
      $(".AmazonFlexGroceryCard").show();
      $(".InstacartCard").show();
      $(".ShiptCard").show();
      $(".Grocery_ChimpsCard").show();
    } else {
      $(".AmazonDeliversShopperCard").hide();
      $(".AmazonFlexGroceryCard").hide();
      $(".InstacartCard").hide();
      $(".ShiptCard").hide();
      $(".Grocery_ChimpsCard").hide();
    }
  });
  // Labor
  $("#AmazonDeliversWarehouseOption").change(function() {
    if ($(this).is(":checked")) {
      $(".AmazonDeliversWarehouseCard").show();
    } else {
      $(".AmazonDeliversWarehouseCard").hide();
    }
  });
  $("#DollyHandsOption").change(function() {
    if ($(this).is(":checked")) {
      $(".DollyHandsCard").show();
    } else {
      $(".DollyHandsCard").hide();
    }
  });
  $("#TaskEasyOption").change(function() {
    if ($(this).is(":checked")) {
      $(".TaskEasyCard").show();
    } else {
      $(".TaskEasyCard").hide();
    }
  });
  $("#HandyOption").change(function() {
    if ($(this).is(":checked")) {
      $(".HandyCard").show();
    } else {
      $(".HandyCard").hide();
    }
  });
  // Care
  $("#WagOption").change(function() {
    if ($(this).is(":checked")) {
      $(".WagCard").show();
    } else {
      $(".WagCard").hide();
    }
  });
  $("#RoverOption").change(function() {
    if ($(this).is(":checked")) {
      $(".RoverCard").show();
    } else {
      $(".RoverCard").hide();
    }
  });
  $("#CareOption").change(function() {
    if ($(this).is(":checked")) {
      $(".CareCard").show();
    } else {
      $(".CareCard").hide();
    }
  });
  // Massage
  $("#ZeelOption").change(function() {
    if ($(this).is(":checked")) {
      $(".ZeelCard").show();
    } else {
      $(".ZeelCard").hide();
    }
  });
  // Language
  $("#LanguageFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      $(".LanguageFreelancerCard").show();
    } else {
      $(".LanguageFreelancerCard").hide();
    }
  });
  $("#TranslateOption").change(function() {
    if ($(this).is(":checked")) {
      $(".TranslateCard").show();
    } else {
      $(".TranslateCard").hide();
    }
  });
  $("#ItalkiOption").change(function() {
    if ($(this).is(":checked")) {
      $(".ItalkiCard").show();
    } else {
      $(".ItalkiCard").hide();
    }
  });
  // Writing
  $("#WritingFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      $(".WritingFreelancerCard").show();
    } else {
      $(".WritingFreelancerCard").hide();
    }
  });
  $("#WritingUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      $(".WritingUpworkCard").show();
    } else {
      $(".WritingUpworkCard").hide();
    }
  });
  $("#WritingFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      $(".WritingFiverrCard").show();
    } else {
      $(".WritingFiverrCard").hide();
    }
  });
  // Art
  $("#ArtGraphicsFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      $(".ArtGraphicsFiverrCard").show();
    } else {
      $(".ArtGraphicsFiverrCard").hide();
    }
  });
  $("#ArtVideoFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      $(".ArtVideoFiverrCard").show();
    } else {
      $(".ArtVideoFiverrCard").hide();
    }
  });
  $("#EtsyOption").change(function() {
    if ($(this).is(":checked")) {
      $(".EtsyCard").show();
    } else {
      $(".EtsyCard").hide();
    }
  });
  // Music
  $("#BeatStarsOption").change(function() {
    if ($(this).is(":checked")) {
      $(".BeatStarsCard").show();
    } else {
      $(".BeatStarsCard").hide();
    }
  });
  $("#MusicFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      $(".MusicFiverrCard").show();
    } else {
      $(".MusicFiverrCard").hide();
    }
  });
  $("#GigFinesseOption").change(function() {
    if ($(this).is(":checked")) {
      $(".GigFinesseCard").show();
    } else {
      $(".GigFinesseCard").hide();
    }
  });
  // Finance
  $("#FinanceUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      $(".FinanceUpworkCard").show();
    } else {
      $(".FinanceUpworkCard").hide();
    }
  });
  $("#GraphiteOption").change(function() {
    if ($(this).is(":checked")) {
      $(".GraphiteCard").show();
    } else {
      $(".GraphiteCard").hide();
    }
  });
  // Tech
  $("#WebFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      $(".WebFreelancerCard").show();
    } else {
      $(".WebFreelancerCard").hide();
    }
  });
  $("#MobileFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      $(".MobileFreelancerCard").show();
    } else {
      $(".MobileFreelancerCard").hide();
    }
  });
  $("#ITUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      $(".ITUpworkCard").show();
    } else {
      $(".ITUpworkCard").hide();
    }
  });
  $("#WebUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      $(".WebUpworkCard").show();
    } else {
      $(".WebUpworkCard").hide();
    }
  });
  $("#DataUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      $(".DataUpworkCard").show();
    } else {
      $(".DataUpworkCard").hide();
    }
  });
  $("#TechFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      $(".TechFiverrCard").show();
    } else {
      $(".TechFiverrCard").hide();
    }
  });
  // Engineering
  $("#EngineeringFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      $(".EngineeringFreelancerCard").show();
    } else {
      $(".EngineeringFreelancerCard").hide();
    }
  });
  $("#EngineeringUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      $(".EngineeringUpworkCard").show();
    } else {
      $(".EngineeringUpworkCard").hide();
    }
  });
  // Business
  $("#SalesFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      $(".SalesFreelancerCard").show();
    } else {
      $(".SalesFreelancerCard").hide();
    }
  });
  $("#BusinessFreelancerOption").change(function() {
    if ($(this).is(":checked")) {
      $(".BusinessFreelancerCard").show();
    } else {
      $(".BusinessFreelancerCard").hide();
    }
  });
  $("#SalesUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      $(".SalesUpworkCard").show();
    } else {
      $(".SalesUpworkCard").hide();
    }
  });
  $("#MarketingFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      $(".MarketingFiverrCard").show();
    } else {
      $(".MarketingFiverrCard").hide();
    }
  });
  $("#BusinessFiverrOption").change(function() {
    if ($(this).is(":checked")) {
      $(".BusinessFiverrCard").show();
    } else {
      $(".BusinessFiverrCard").hide();
    }
  });
  // Legal
  $("#LegalUpworkOption").change(function() {
    if ($(this).is(":checked")) {
      $(".LegalUpworkCard").show();
    } else {
      $(".LegalUpworkCard").hide();
    }
  });
  // Assets
  $("#AssetCarOption").change(function() {
    if ($(this).is(":checked")) {
      $(".TuroCard").show();
      $(".GetaroundCard").show();
    } else {
      $(".TuroCard").hide();
      $(".GetaroundCard").hide();
    }
  });
  $("#AirbnbOption").change(function() {
    if ($(this).is(":checked")) {
      $(".AirbnbCard").show();
    } else {
      $(".AirbnbCard").hide();
    }
  });
});  