# Things to write tests for
* What happens if i use namespaces?
* What happens if i use closures and call them like `$closure()`?
* What happens if a relevant statement spans several lines? is that even possible
  with the relations i defined so far?
* What happens if i use a 'multi global' statement: global $a1, $a2;

# Definition
* Expose `everything` in definition language.
* Make `language_construct` more pleasant to use.
* Define known types of `language_construct`s.

# DB
* Maybe make rules (and maybe vars) able to initialize their own tables.
* Maybe move DBs to their own namespace.

# Cleanup
* Every submodule could have its own Config, those could then be combined to the
  big global config.
* DBFactory is a misnomer. Its more like a manager, which is a very non descriptive
  word.
* Introduce a RegExp class to put checking for validity in one place.
* Use custom rules in indexer test.
* Engine starts to become a mess, maybe it could be refactored to use some different
  classes.

# Report
* Introduce some nice way to use different and also custom report generators. That
  would mean to introduce the possibility to add custom classes to the config. 

# Issues
* `trait`s are unknown atm.
* `GUIClasses cannot depend on ilDB` finds some locations twice on ILIAS. This is
  caused by the fact, that "classes invoke stuff in their methods" and said methods
  do this as well.
* It is inconsistent, that Invoke makes invocations in methods of classes related
  to the class itself, but `only XYZClasses can invoke` also flags the methods in
  XYZClasses.
* The language for rules currently is more powerful than the analysis. I can say
  something like `Classes cannot relate to Methods in OtherClasses` but i would
  not be able to analyse that rule correctly, as method_references are not related
  to a class.
* It seems as everything that "invokes" should also "depend on".

# Execution plan for introducing git (and further improvements)
* The engine then somehow needs to figure out what to do based on the last run and
  the current state of the source.
    -> This would also mean that we could also only reindex files that have changed
       between two commits.
